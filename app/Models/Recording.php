<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Recording extends Model {
    protected $fillable = ['test_attempt_id','file_path','duration_seconds','band_score','admin_feedback'];
    public function testAttempt() { return $this->belongsTo(TestAttempt::class); }
}
