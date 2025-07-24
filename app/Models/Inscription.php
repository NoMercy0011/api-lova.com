<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'inscription';

    protected $primaryKey ='id_inscription';
    protected $fillable =[
        'etudiant_id',
        'matricule',
        'classe_id',
        'date_entree',
        'date_sortie',
        'raison_sortie',
        'annee_scolaire_id',
        'ecole_precedente',
        'sortie_ecole_precedente',
        'raison_admission',
        'status', // passant , redoublant, triplant
        'archive', // en archive, supprimer, etc...
    ];

    public function etudiant(){
        return $this->belongsTo(Etudiant::class, 'etudiant_id', 'id_etudiant');
    }

    public function classe(){
        return $this->belongsTo(Classe::class, 'classe_id', 'id_classe');
    }
    public function anneeScolaire(){
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
    public function noteEtudiants(){
        return $this->hasMany(Note::class, 'etudiant_id', 'id_inscription');
    }
    public function bulletinEtudiants(){
        return $this->hasMany(Bulletin::class, 'etudiant_id', 'id_inscription');
    }
}
