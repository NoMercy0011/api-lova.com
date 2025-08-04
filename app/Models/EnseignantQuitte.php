<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantQuitte extends Model
{
    use HasFactory;
    protected $connection = 'tenant';
    protected $primaryKey = 'id_enseignant_quitte';
    protected $table= 'enseignant_quitte';

    protected $fillable = [
        'user_id',
        'date_sortie',
        'raison',
        'status',       // Active, Archive, Supprimé
    ];
    public function enseignant() {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
