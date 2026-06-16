<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class WritingSubmission extends Model {
    protected $fillable = ['test_attempt_id','section_id','task1_response','task1_word_count','task2_response','task2_word_count','band_score','admin_feedback'];
    public function testAttempt() { return $this->belongsTo(TestAttempt::class); }
}
