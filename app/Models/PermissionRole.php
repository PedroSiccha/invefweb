<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    use HasFactory;
    protected $table = 'permission_role';
    protected $fillable = ['id', 'roles_id', 'permissions_id'];

    public static function proRol($id){
    	return PermissionRole::where('roles_id', '=', $id) -> get();
    }
    public static function proPer($id){
    	return PermissionRole::where('permissions_id', '=', $id) -> get();
    }
}
