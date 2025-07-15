<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $connection = 'tenant';
    protected $table = 'user';
    protected  $primaryKey= 'id_user';
     protected $fillable = [
        'email',
        'pseudo',
        'password',
        'nom',
        'prenom',
        'sexe',
        'date_naissance',
        'lieu_naissance',
        'telephone',
        'photo',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function devisLivres(){
    //     return $this->hasMany(DevisLivre::class, 'personnel', 'id');
    // }
}
