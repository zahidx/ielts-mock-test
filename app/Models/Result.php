<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Result extends Model {
    protected $fillable = ['test_attempt_id','section_id','correct_count','total_questions','band_score'];
    public function testAttempt() { return $this->belongsTo(TestAttempt::class); }
    public function section() { return $this->belongsTo(Section::class); }
}
