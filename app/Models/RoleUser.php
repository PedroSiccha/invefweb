<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'userrol';
    protected $fillable = ['id', 'estado', 'users_id', 'rol_id'];

    public static function rusUse($id){
    	return RoleUser::where('users_id', '=', $id) -> get();
    }
    public static function rusRol($id){
    	return RoleUser::where('rol_id', '=', $id) -> get();
    }
}
