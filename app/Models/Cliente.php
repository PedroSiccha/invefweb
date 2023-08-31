<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $table = 'cliente';
    protected $fillable = ['id', 'nombres', 'apellidos', 'dni', 'correo', 'fecnac', 'edad', 'genero', 'foto', 'facebook', 'ingmax', 'ingmin', 'gasmax', 'gasmin', 'evaluacion', 'tipodocide_id', 'direccion_id', 'ocupacion_id', 'recomendacion_id', 'users_id', 'evaluacion', 'telefono', 'whatsapp', 'referencia', 'sede_id'];

    public static function cliOcu($id){
    	return Cliente::where('ocupacion_id', '=', $id) -> get();
    }
    public static function cliRecTri($id){
    	return Cliente::where('recomendacion_id', '=', $id) -> get();
    }
    
    public static function cliTdi($id){
        return Cliente::where('tipodocid_id', '=', $id) -> get();
    }

    public static function cliDir($id){
        return Cliente::where('direccion_id', '=', $id) -> get();
    }

    public static function cliUsr($id){
        return Cliente::where('users_id', '=', $id) -> get();
    }

    public static function cliSed($id){
        return Cliente::where('sede_id', '=', $id) -> get();
    }

    public function obtenerImagen(){
        return '/storage/app'.$this->foto;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
