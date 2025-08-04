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
        'pseudo',
        'password',
        'nom',
        'prenom',
        'email',
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

    public function etablissementChefs(){
        return $this->hasMany(Etablissement::class, 'user_id', 'id_user');
    }

    public function etablissementEditeurs(){
        return $this->hasMany(Etablissement::class, 'editeur_id', 'id_user');
    }

    public function enseignementUsers(){
        return $this->hasMany(Enseignement::class, 'enseignant_id', 'id_user');
    }
    public function enseignementDeleters(){
        return $this->hasMany(Enseignement::class, 'suppresseur_id', 'id_user');
    }
    public function noteEnseignants(){
        return $this->hasMany(Note::class, 'enseignant_id', 'id_user');
    }
    public function enseignantsActives(){
        return $this->hasMany(EnseignantActive::class, 'user_id', 'id_user');
    }
    public function enseignantsQuittes(){
        return $this->hasMany(EnseignantQuitte::class, 'user_id', 'id_user');
    }
}
