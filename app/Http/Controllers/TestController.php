<?php
namespace App\Http\Controllers;

use App\Models\Test;
use App\Models\Section;
use App\Models\TestAttempt;
use App\Models\Answer;
use App\Models\Result;
use App\Models\WritingSubmission;
use App\Models\Recording;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    public function dashboard() {
        $tests = Test::where('is_active',true)->get();
        $attempts = TestAttempt::where('user_id',Auth::id())->with(['test','results.section','writingSubmission'])->latest()->get();
        return view('test.dashboard', compact('tests','attempts'));
    }

    public function startTest(Test $test) {
        $attempt = TestAttempt::create(['user_id'=>Auth::id(),'test_id'=>$test->id,'status'=>'in_progress','current_section'=>'listening']);
        $first = $test->sections()->orderBy('order')->first();
        if (!$first) return redirect()->route('user.dashboard')->with('info','No sections.');
        return redirect()->route('test.section',['attempt'=>$attempt->id,'section'=>$first->id]);
    }

    public function showSection(TestAttempt $attempt, Section $section) {
        if ($attempt->user_id !== Auth::id()) abort(403);
        if ($attempt->status === 'completed') return redirect()->route('user.dashboard')->with('info','Already completed.');
        $section->load('questions.options');
        $allSections = $attempt->test->sections()->orderBy('order')->get();
        $existingAnswers = Answer::where('test_attempt_id',$attempt->id)->whereIn('question_id',$section->questions->pluck('id'))->pluck('answer_text','question_id');
        $writingSub = $section->type==='writing' ? WritingSubmission::where('test_attempt_id',$attempt->id)->where('section_id',$section->id)->first() : null;
        return view('test.section', compact('attempt','section','allSections','existingAnswers','writingSub'));
    }

    public function saveAnswer(Request $request) {
        $attempt = TestAttempt::findOrFail($request->attempt_id);
        if ($attempt->user_id !== Auth::id()) abort(403);
        Answer::updateOrCreate(['test_attempt_id'=>$attempt->id,'question_id'=>$request->question_id],['answer_text'=>$request->answer_text]);
        return response()->json(['status'=>'saved']);
    }

    public function saveWriting(Request $request) {
        $attempt = TestAttempt::findOrFail($request->attempt_id);
        if ($attempt->user_id !== Auth::id()) abort(403);
        WritingSubmission::updateOrCreate(['test_attempt_id'=>$attempt->id,'section_id'=>$request->section_id],[
            'task1_response'=>$request->task1_response,'task1_word_count'=>str_word_count($request->task1_response??''),
            'task2_response'=>$request->task2_response,'task2_word_count'=>str_word_count($request->task2_response??''),
        ]);
        return response()->json(['status'=>'saved']);
    }

    public function saveRecording(Request $request) {
        $attempt = TestAttempt::findOrFail($request->attempt_id);
        if ($attempt->user_id !== Auth::id()) abort(403);
        if ($request->hasFile('audio')) {
            $path = $request->file('audio')->store('recordings','public');
            Recording::create(['test_attempt_id'=>$attempt->id,'file_path'=>$path]);
            return response()->json(['status'=>'saved']);
        }
        return response()->json(['status'=>'error'],400);
    }

    public function clearAnswer(Request $request) {
        $attempt = TestAttempt::findOrFail($request->attempt_id);
        if ($attempt->user_id !== Auth::id()) abort(403);
        Answer::where('test_attempt_id',$attempt->id)->where('question_id',$request->question_id)->delete();
        return response()->json(['status'=>'cleared']);
    }

    public function submitSection(Request $request, TestAttempt $attempt, Section $section) {
        if ($attempt->user_id !== Auth::id()) abort(403);
        if (in_array($section->type,['listening','reading'])) $this->gradeSection($attempt,$section);
        $all = $attempt->test->sections()->orderBy('order')->get();
        $idx = $all->search(fn($s)=>$s->id===$section->id);
        $next = $all->get($idx+1);
        if ($next) { $attempt->update(['current_section'=>$next->type]); return redirect()->route('test.section',['attempt'=>$attempt->id,'section'=>$next->id]); }
        $attempt->update(['status'=>'completed','current_section'=>null]);
        return redirect()->route('test.complete',$attempt->id);
    }

    private function gradeSection(TestAttempt $attempt, Section $section) {
        $correct = 0;
        foreach ($section->questions as $q) {
            $ans = Answer::where('test_attempt_id',$attempt->id)->where('question_id',$q->id)->first();
            if ($ans && $q->correct_answer) {
                $ok = strtolower(trim($ans->answer_text))===strtolower(trim($q->correct_answer));
                $ans->update(['is_correct'=>$ok]); if ($ok) $correct++;
            }
        }
        $total = $section->questions->count();
        $pct = $total>0?($correct/$total)*100:0;
        $bands = $section->type==='listening'
            ? [[95,9],[85,8.5],[80,8],[72,7.5],[65,7],[55,6.5],[47,6],[38,5.5],[30,5],[22,4.5],[15,4],[10,3.5],[5,3]]
            : [[95,9],[87,8.5],[80,8],[72,7.5],[65,7],[57,6.5],[50,6],[42,5.5],[35,5],[27,4.5],[20,4],[13,3.5],[7,3]];
        $band = 2.5;
        foreach ($bands as [$th,$b]) { if ($pct>=$th) { $band=$b; break; } }
        Result::updateOrCreate(['test_attempt_id'=>$attempt->id,'section_id'=>$section->id],['correct_count'=>$correct,'total_questions'=>$total,'band_score'=>$band]);
    }

    public function complete(TestAttempt $attempt) {
        if ($attempt->user_id !== Auth::id()) abort(403);
        $attempt->load(['test','results.section','writingSubmission']);
        return view('test.complete', compact('attempt'));
    }
}
