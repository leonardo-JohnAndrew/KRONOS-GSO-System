<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class organization extends Model
{
    //
    protected $table = 'organizations';
    public function positions()
    {
        return  $this->hasMany(position::class, 'orgID', 'orgID');
    }
    public function department()
    {
        return  $this->belongsTo(department::class, 'dprtID', 'dprtID');
    }
}
