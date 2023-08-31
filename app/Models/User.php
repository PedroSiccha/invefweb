<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Empleado;
use App\Models\Cliente;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rol()
    {
        return $this->belongsToMany(Rol::class, 'userrol');
    }

    public function setSession($roles)
    {
        if (count($roles) == 1) {
            Session::put(
                [
                    'rol_id' => $roles[0]->id,
                    'rol_nombre' => $roles[0]->nombre,
                    'usuario' => $this->username,
                    'nombre_usuario' => $this->name,
                    'usuario_id' => $this->id
                    //'nombre' => $this->nombre
                ]
            );
        }
    }

    public function empleado()
    {
        return $this->hasOne(Empleado::class, 'users_id');
    }
    
    public function cliente()
    {
        return $this->hasOne(Cliente::class, 'users_id');
    }
}
