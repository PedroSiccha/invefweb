<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $table = 'chat';
    protected $fillable = ['id', 'asunto', 'mensaje', 'estado', 'recibe_id', 'envia_id'];

    public static function chaRec($id){
    	return Chat::where('recibe_id', '=', $id) -> get();
    }

    public static function chaEnv($id){
        return Chat::where('envia_id', '=', $id) -> get();
    }
}
