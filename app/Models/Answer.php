<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Answer extends Model {
    protected $fillable = ['test_attempt_id','question_id','answer_text','is_correct'];
    public function testAttempt() { return $this->belongsTo(TestAttempt::class); }
    public function question() { return $this->belongsTo(Question::class); }
}
