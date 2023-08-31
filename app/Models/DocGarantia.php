<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocGarantia extends Model
{
    protected $table = 'docgarantia';
    protected $fillable = ['id', 'nombre', 'ruta', 'garantia_id'];

    public static function dgaGar($id){
    	return Docgarantia::where('garantia_id', '=', $id) -> get();
    }
}
