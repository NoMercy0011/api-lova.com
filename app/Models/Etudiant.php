<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $table = 'etudiants';

    protected $primaryKey ='id_etudiant';
    protected $fillable =[
        'nom',
        'prenom',
        'date_naissance',
        'lieu_naissance',
        'sexe',
        'domicile',
        'nom_pere',
        'nom_mere',
        'telephone_parent',
        'nom_tuteur',
        'telephone_tuteur',
        'telephone_usrgence',
    ];

    public function inscriptions(){
        return $this->hasMany(Inscription::class, 'etudiant_id', 'id_etudiant');
    }
}
