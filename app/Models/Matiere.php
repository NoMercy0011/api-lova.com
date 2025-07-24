<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    use HasFactory;

    protected $connection = 'tenant';

    protected $table = 'matiere';

    protected $primaryKey ='id_matiere';
    protected $fillable =[
        'matiere',
        'code',       
    ];

    public function noteMatieres(){
        return $this->hasMany(Note::class, 'matiere_id', 'id_matiere');
    }
}
