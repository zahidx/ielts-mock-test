<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class TestAttempt extends Model {
    protected $fillable = ['user_id','test_id','status','current_section'];
    public function user() { return $this->belongsTo(User::class); }
    public function test() { return $this->belongsTo(Test::class); }
    public function answers() { return $this->hasMany(Answer::class); }
    public function results() { return $this->hasMany(Result::class); }
    public function writingSubmission() { return $this->hasOne(WritingSubmission::class); }
    public function recordings() { return $this->hasMany(Recording::class); }
}
