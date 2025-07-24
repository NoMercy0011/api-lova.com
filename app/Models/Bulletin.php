<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;
    protected $connection = 'tenant';

    protected $table = 'bulletin';

    protected $primaryKey ='id_bulletin';
    protected $fillable =[
        'etudiant_id',
        'total_coefficient',
        'total_note',
        'moyenne',
        'observation',
        'periode_id',
    ];

    public function etudiant(){
        return $this->belongsTo(Inscription::class, 'etudiant_id', 'id_inscription');
    }
    public function periode(){
        return $this->belongsTo(Periode::class, 'periode_id', 'id_periode');
    }
}
