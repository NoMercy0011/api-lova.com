<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'niveau';

    protected $primaryKey ='id_niveau';
    protected $fillable =[
        'niveau',
    ];

    
    public function niveauClasses(){
        return $this->hasMany(Classe::class, 'niveau_id', 'id_niveau');
    }
}
