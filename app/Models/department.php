<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    //
    protected $table = 'departments';

    public function organizations()
    {
        return   $this->hasMany(organization::class, 'dprtID', 'dprtID');
    }
}
