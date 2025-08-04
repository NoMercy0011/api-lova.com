<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $connection ='tenant';
    protected $table ='section';
    protected $primaryKey = 'id_section';
    protected $fillable = [
        'section',
        'departement',
        'cycle',
        'description',
    ];

    public function sectionEnseignantActives() {
        return $this->hasMany(EnseignantActive::class, 'section_id', 'id_section');
    }

    public function sectionClasses() {
        return $this->hasMany(Classe::class, 'section_id', 'id_section');
    }
}
