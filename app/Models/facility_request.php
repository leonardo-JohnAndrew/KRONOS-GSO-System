<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class facility_request extends Model
{
    use HasFactory;

    protected $table = 'facility_request';

    protected $fillable = [
        'facilityID',
        'reqstCODE',
        'dateSubmit',
        'activity',
        'purpose',
        'activityType',
        'activityDateStart',
        'activityDateEnd',
        'venue',
        'participants',
        'note'

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($facilityRequest) {
            $facilityRequest->reqstCODE = self::generateNextRequestCoded();
        });
    }


    public static function generateNextRequestCoded()
    {
        $latestRequest = self::where('reqstCODE', 'like', "GSO-FR-%")
            ->orderBy('reqstCODE', 'desc')
            ->first();

        if (!$latestRequest) {
            return "GSO-FR-0001";
        }

        // Extract numeric part and increment
        $lastNumber = (int) substr($latestRequest->reqstCODE, 8);
        return "GSO-FR-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'userid');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'reqstCODE', 'reqstCODE');
    }
    public function admin_facility_request()
    {
        $this->belongsTo(admin_facility_request::class, 'reqstCODE', 'reqsrCODE');
    }
    public function deans_request()
    {
        $this->belongsTo(deans_Approval::class, 'reqstCODE', 'reqsrCODE');
    }
    public function request()
    {
        $this->belongsTo(requests::class, 'reqstCODE', 'reqstCODE');
    }
}
