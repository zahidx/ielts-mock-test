<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Test;
use App\Models\Section;
use App\Models\Question;
use App\Models\Option;
use App\Models\TestAttempt;
use App\Models\WritingSubmission;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard() {
        $stats = ['users'=>User::where('is_admin',false)->count(),'tests'=>Test::count(),'attempts'=>TestAttempt::where('status','completed')->count()];
        $recentAttempts = TestAttempt::with(['user','test'])->where('status','completed')->latest()->take(10)->get();
        return view('admin.dashboard', compact('stats','recentAttempts'));
    }

    // Users
    public function users() { return view('admin.users', ['users'=>User::where('is_admin',false)->latest()->get()]); }
    public function createUser(Request $request) {
        $request->validate(['user_id'=>'required|unique:users,user_id','name'=>'required','password'=>'required|min:4']);
        User::create(['user_id'=>$request->user_id,'name'=>$request->name,'password'=>Hash::make($request->password)]);
        return back()->with('success','User created.');
    }
    public function deleteUser(User $user) { $user->delete(); return back()->with('success','User deleted.'); }

    // Tests
    public function tests() { return view('admin.tests.index', ['tests'=>Test::withCount('sections')->latest()->get()]); }
    public function createTest() { return view('admin.tests.create'); }
    public function storeTest(Request $request) {
        $request->validate(['title'=>'required']);
        $test = Test::create($request->only('title','description'));
        return redirect()->route('admin.tests.show',$test)->with('success','Test created.');
    }
    public function showTest(Test $test) { $test->load('sections.questions'); return view('admin.tests.show', compact('test')); }
    public function editTest(Test $test) { return view('admin.tests.edit', compact('test')); }
    public function updateTest(Request $request, Test $test) {
        $request->validate(['title'=>'required']);
        $test->update($request->only('title','description','is_active'));
        return redirect()->route('admin.tests.show',$test)->with('success','Test updated.');
    }
    public function deleteTest(Test $test) { $test->delete(); return redirect()->route('admin.tests')->with('success','Test deleted.'); }
    public function toggleTest(Test $test) { $test->update(['is_active'=>!$test->is_active]); return back()->with('success','Status updated.'); }

    // Sections
    public function createSection(Test $test) { return view('admin.sections.create', compact('test')); }
    public function storeSection(Request $request, Test $test) {
        $request->validate(['type'=>'required|in:listening,reading,writing,speaking','title'=>'required','duration_minutes'=>'required|integer|min:1']);
        $section = Section::create(['test_id'=>$test->id,'type'=>$request->type,'title'=>$request->title,'duration_minutes'=>$request->duration_minutes,'order'=>($test->sections()->max('order')??0)+1,'content'=>$request->content,'content_extra'=>$request->content_extra]);
        if ($request->type==='listening' && $request->hasFile('audio_file')) {
            $f=$request->file('audio_file'); $fn='listening_'.$test->id.'_'.time().'.'.$f->getClientOriginalExtension();
            $f->move(public_path('audio'),$fn); $section->update(['content'=>'audio/'.$fn]);
        }
        return redirect()->route('admin.tests.show',$test)->with('success','Section added.');
    }
    public function editSection(Test $test, Section $section) { return view('admin.sections.edit', compact('test','section')); }
    public function updateSection(Request $request, Test $test, Section $section) {
        $data = $request->only('title','duration_minutes','content','content_extra','order');
        if ($request->hasFile('audio_file')) {
            $f=$request->file('audio_file'); $fn='listening_'.$test->id.'_'.time().'.'.$f->getClientOriginalExtension();
            $f->move(public_path('audio'),$fn); $data['content']='audio/'.$fn;
        }
        $section->update($data);
        return redirect()->route('admin.tests.show',$test)->with('success','Section updated.');
    }
    public function deleteSection(Test $test, Section $section) { $section->delete(); return redirect()->route('admin.tests.show',$test)->with('success','Section deleted.'); }

    // Questions
    public function manageQuestions(Test $test, Section $section) { $section->load('questions.options'); return view('admin.questions.index', compact('test','section')); }
    public function createQuestion(Test $test, Section $section) { return view('admin.questions.create', compact('test','section')); }
    public function storeQuestion(Request $request, Test $test, Section $section) {
        $request->validate(['question_number'=>'required|integer','question_text'=>'required','question_type'=>'required|in:mcq,true_false_ng,fill_blank,matching,short_answer']);
        $q = Question::create(['section_id'=>$section->id,'question_number'=>$request->question_number,'question_text'=>$request->question_text,'question_type'=>$request->question_type,'correct_answer'=>$request->correct_answer,'group_label'=>$request->group_label,'order'=>($section->questions()->max('order')??0)+1]);
        if (in_array($request->question_type,['mcq','matching']) && $request->has('option_labels')) {
            foreach ($request->option_labels as $i=>$label) {
                if (!empty($request->option_texts[$i])) Option::create(['question_id'=>$q->id,'label'=>$label,'option_text'=>$request->option_texts[$i]]);
            }
        }
        if ($request->has('add_another')) return redirect()->route('admin.questions.create',[$test,$section])->with('success',"Q#{$request->question_number} added.");
        return redirect()->route('admin.questions.index',[$test,$section])->with('success','Question added.');
    }
    public function editQuestion(Test $test, Section $section, Question $question) { $question->load('options'); return view('admin.questions.edit', compact('test','section','question')); }
    public function updateQuestion(Request $request, Test $test, Section $section, Question $question) {
        $question->update($request->only('question_number','question_text','question_type','correct_answer','group_label','order'));
        if (in_array($question->question_type,['mcq','matching'])) {
            $question->options()->delete();
            if ($request->has('option_labels')) {
                foreach ($request->option_labels as $i=>$label) {
                    if (!empty($request->option_texts[$i])) Option::create(['question_id'=>$question->id,'label'=>$label,'option_text'=>$request->option_texts[$i]]);
                }
            }
        }
        return redirect()->route('admin.questions.index',[$test,$section])->with('success','Question updated.');
    }
    public function deleteQuestion(Test $test, Section $section, Question $question) { $question->delete(); return back()->with('success','Question deleted.'); }
    public function bulkImportForm(Test $test, Section $section) { return view('admin.questions.bulk_import', compact('test','section')); }
    public function bulkImport(Request $request, Test $test, Section $section) {
        $request->validate(['questions_data'=>'required']);
        $lines = preg_split('/\r\n|\r|\n/', trim($request->questions_data)); $imported = 0;
        foreach ($lines as $line) {
            $line = trim($line); if (empty($line)) continue;
            $parts = explode('|', $line); if (count($parts)<4) continue;
            $q = Question::create(['section_id'=>$section->id,'question_number'=>(int)trim($parts[0]),'question_text'=>trim($parts[1]),'question_type'=>trim($parts[2]),'correct_answer'=>trim($parts[3]),'group_label'=>isset($parts[4])?trim($parts[4]):null,'order'=>($section->questions()->max('order')??0)+1]);
            for ($i=5;$i<count($parts);$i++) { $opt=trim($parts[$i]); if (str_contains($opt,':')) { [$l,$t]=explode(':',$opt,2); Option::create(['question_id'=>$q->id,'label'=>trim($l),'option_text'=>trim($t)]); } }
            $imported++;
        }
        return redirect()->route('admin.questions.index',[$test,$section])->with('success',"$imported questions imported.");
    }

    // Results
    public function results() { return view('admin.results', ['attempts'=>TestAttempt::with(['user','test','results.section','writingSubmission'])->where('status','completed')->latest()->get()]); }
    public function attemptDetail(TestAttempt $attempt) { $attempt->load(['user','test','answers.question','results.section','writingSubmission','recordings']); return view('admin.attempt_detail', compact('attempt')); }
    public function saveWritingScore(Request $request, WritingSubmission $submission) { $submission->update($request->only('band_score','admin_feedback')); return back()->with('success','Score saved.'); }
    public function saveSpeakingScore(Request $request, Recording $recording) { $recording->update($request->only('band_score','admin_feedback')); return back()->with('success','Score saved.'); }
}
