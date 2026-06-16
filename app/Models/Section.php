<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Section extends Model {
    protected $fillable = ['test_id','type','title','duration_minutes','order','content','content_extra'];
    public function test() { return $this->belongsTo(Test::class); }
    public function questions() { return $this->hasMany(Question::class)->orderBy('order'); }
}
