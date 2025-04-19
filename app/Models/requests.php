<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class requests extends Model
{
    //

    protected $fillable = [
        'reqstCODE',
        'request_type'
    ];
    public function facility_request()
    {
        $this->belongsTo(facility_request::class, 'reqstCODE', 'reqstCODE');
    }
    public function service_request()
    {
        $this->belongsTo(service_request::class, 'reqstCODE', 'reqstCODE');
    }
    public function job_request()
    {
        $this->belongsTo(job_request::class, 'reqstCODE', 'reqstCODE');
    }
    public function purchase_request()
    {
        $this->belongsTo(purchase_request::class, 'reqstCODE', 'reqstCODE');
    }
}
