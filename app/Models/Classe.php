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
        'responsable_id',
        'annee_scolaire_id',
    ];
    public function niveau(){
        return $this->belongsTo(Niveau::class, 'niveau_id', 'id_niveau');
    }
    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id', 'id_user');
    }

    public function anneeScolaire(){
        return $this->belongsTo(AnneeScolaire::class, 'annee_scolaire_id', 'id_annee_scolaire');
    }
    public function inscriptions(){
        return $this->hasMany(Inscription::class, 'classe_id', 'id_classe');
    }
}
