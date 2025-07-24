<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'periodes';

    protected $primaryKey ='id_periode';
    protected $fillable =[
        'nom',
        'ordre',
        'date_debut',
        'date_fin',
        'annee_scolaire_id',
    ];

    public function anneeSclolaire() {
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id','id_annee_scolaire');
    }
    public function notePeriodes(){
        return $this->hasMany(Note::class, 'periode_id', 'id_periode');
    }
    public function bulletinPeriodes(){
        return $this->hasMany(Bulletin::class, 'periode_id', 'id_periode');
    }
}
