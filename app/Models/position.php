<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class position extends Model
{
    //
    protected $table = "positions";
    public function organizations()
    {
        return   $this->belongsTo(organization::class, 'orgID', 'orgID');
    }
}
