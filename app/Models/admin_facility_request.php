<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admin_facility_request extends Model
{
    //
    use HasFactory;

    protected $table = "gso_facility";

    public function facility_request()
    {
        $this->belongsTo(facility_request::class, 'reqstCODE', 'reqsrCODE');
    }
}
