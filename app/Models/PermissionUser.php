<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionUser extends Model
{
    protected $table = 'permission_user';
    protected $fillable = ['id', 'users_id', 'permissions_id'];

    public static function pusUsr($id){
    	return PermissionUser::where('users_id', '=', $id) -> get();
    }
    public static function pusPer($id){
    	return PermissionUser::where('permissions_id', '=', $id) -> get();
    }
}
