<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $table = 'note';
    protected $primaryKey = 'id_note';
    protected $fillable = [
        'enseignant_id',
        'etudiant_id',
        'matiere_id',
        'note',
        'type',
        'periode_id',
    ];

    public function enseignant(){
        return $this->belongsTo(User::class, 'enseignant_id', 'id_user');
    }
    public function etudiant(){
        return $this->belongsTo(Inscription::class, 'etudiant_id', 'id_inscription');
    }
    public function matiere(){
        return $this->belongsTo(Matiere::class, 'matiere_id', 'id_matiere');
    }
    public function periode(){
        return $this->belongsTo(Periode::class, 'periode_id', 'id_periode');
    }
}
