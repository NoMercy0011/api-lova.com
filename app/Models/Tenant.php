<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant
{
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'non_client',
        'etablissement',
        'database',
        'contact',
        'addresse',
        'dot_env',
    ];
    protected $casts = [
        // don't cast 'data' anymore
    ];
}
