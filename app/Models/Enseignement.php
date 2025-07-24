<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $primaryKey = 'id_enseignement';

    protected $table = 'enseignement';

    protected $fillable = [
        'classe_id',
        'matiere_id',
        'enseignant_id',
        'coefficient',
        'horaire',
        'annee_scolaire_id',
        'deleted_at',
        'suppresseur_id',
        'archive',
    ];
    public function classe(){
        return $this->belongsTo(Classe::class, 'classe_id', 'id_classe');
    }
    public function matiere(){
        return $this->belongsTo(Matiere::class, 'matiere_id', 'id_matiere');
    }
    public function anneeScolaire(){
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
    public function enseignant(){
        return $this->belongsTo(User::class, 'enseignant_id', 'id_user');
    }
    public function suppresseur(){
        return $this->belongsTo(User::class, 'suppresseur_id', 'id_user');
    }
}
