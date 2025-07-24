<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $primaryKey = 'id_etablissement';

    protected $table = 'etablissement';

    protected $fillable = [
        'etablissement',
        'ville',
        'region',
        'user_id',
        'contact',
        'code',
        'email',
        'adresse',
        'editeur_id'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
    public function editeur(){
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
