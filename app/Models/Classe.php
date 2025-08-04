<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $table = 'classe';

    protected $primaryKey ='id_classe';
    protected $fillable =[
        'classe',
        'niveau_id',
        'section_id',
        'responsable_id',
        'annee_scolaire_id',
    ];
    public function niveau(){
        return $this->belongsTo(Niveau::class, 'niveau_id', 'id_niveau');
    }
    public function responsable(){
        return $this->belongsTo(EnseignantActive::class, 'responsable_id', 'id_enseignant_active');
    }

    public function anneeScolaire(){
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id_section');
    }
    public function inscriptions(){
        return $this->hasMany(Inscription::class, 'classe_id', 'id_classe');
    }
}
