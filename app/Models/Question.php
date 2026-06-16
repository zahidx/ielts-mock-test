<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Question extends Model {
    protected $fillable = ['section_id','question_number','question_text','question_type','correct_answer','group_label','order'];
    public function section() { return $this->belongsTo(Section::class); }
    public function options() { return $this->hasMany(Option::class); }
}
