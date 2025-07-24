<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnneeScolaire extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'annee_scolaire';

    protected $primaryKey ='id_annee_scolaire';
    protected $fillable =[
        'annee_scolaire',
        'annee_debut',
        'annee_fin',
        'status',
    ];

    public function periodes() {
        return $this->hasMany(Periode::class, 'annee_scolaire_id','id_annee_scolaire');
    }

    public function inscriptions(){
        return $this->hasMany(Inscription::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
    public function enseignements(){
        return $this->hasMany(Enseignement::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
}
