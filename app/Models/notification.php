<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class notification extends Model
{
    //
    protected $table = 'notification';
    protected $fillable = [
        'reqstCODE',
        'notification',
        'userid',

    ];

    public function users()
    {
        $this->belongsTo(User::class, 'userid', 'userid');
    }
    public function request()
    {
        $this->belongsTo(requests::class, 'reqstCODE', 'reqstCODE');
    }
}
