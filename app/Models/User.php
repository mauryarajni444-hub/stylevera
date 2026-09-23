<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
class User extends Authenticatable {
    protected $fillable=['name','email','password','role','phone','avatar','address','city','country','is_active','created_by'];
    protected $hidden=['password','remember_token'];
    public function isMaster():bool{return $this->role==='master_admin';}
    public function isAdmin():bool{return in_array($this->role,['master_admin','admin']);}
}