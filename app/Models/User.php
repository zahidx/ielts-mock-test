<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable {
    protected $fillable = ['user_id','name','password','is_admin'];
    protected $hidden = ['password'];
    protected $casts = ['is_admin' => 'boolean'];
    public function testAttempts() { return $this->hasMany(TestAttempt::class); }
}
