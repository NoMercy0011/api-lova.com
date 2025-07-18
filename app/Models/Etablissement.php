<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etablissement extends Model
{
    use HasFactory;

    protected $connection = 'tenant';
    protected  $primaryKey = 'id_etablissement';

    protected $fillable = [
        'etablissement',
        'chef_etablissement',
        'contact',
        'code',
        'email',
        'editeur',
    ];
}
