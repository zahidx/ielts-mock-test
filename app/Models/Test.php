<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Test extends Model {
    protected $fillable = ['title','description','is_active'];
    public function sections() { return $this->hasMany(Section::class)->orderBy('order'); }
    public function attempts() { return $this->hasMany(TestAttempt::class); }
}
