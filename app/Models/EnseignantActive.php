<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantActive extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_enseignant_active';
    protected $table= 'enseignant_active';

    protected $fillable = [
        'user_id',
        'section_id',
        'date_entree',
        'salaire',
        'status',
    ];
    public function enseignant() {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    public function section() {
        return $this->belongsTo(Section::class, 'section_id', 'id_section');
    }
    public function classeResponsables(){
        return $this->hasMany(Classe::class, 'responsable_id', 'id_enseignant_active');
    }
}
