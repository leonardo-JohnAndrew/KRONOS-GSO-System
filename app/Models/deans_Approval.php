<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class deans_Approval extends Model
{
    //
    use HasFactory;
    protected $table = 'deans_Approval';
    protected $fillable = [
        'deansApprovalID',
        'reqstCODE',
        'deanID',
        'deanApproval',
        'notification',
        'reason',
        'deanDateApproval',
        'type',
        'remark',
    ];

    public function facility_request()
    {
        $this->belongsTo(facility_request::class, 'reqstCODE', 'reqstCODE');
    }
}
