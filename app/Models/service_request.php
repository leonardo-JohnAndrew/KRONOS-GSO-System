<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class service_request extends Model
{
    /** @use HasFactory<\Database\Factories\ServiceRequestFactory> */
    use HasFactory;

    protected $table = 'service_request';

    protected $fillable = [
        'reqstCODE',
        'userid',
        'dateSubmit',
        'timeDeparture',
        'timeArrival',
        'dateArrival',
        'dateNeeded',
        'noOfPassenger',
        'destination',
        'passengerName',
        'purpose'
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($serviceRequest) {
            $serviceRequest->reqstCODE = self::generateNextRequestCoded();
        });
    }
    public static function generateNextRequestCoded()
    {
        $latestRequest = self::where('reqstCODE', 'like', "GSO-VR-%")
            ->orderBy('reqstCODE', 'desc')
            ->first();

        if (!$latestRequest) {
            return "GSO-VR-0001";
        }

        // Extract numeric part and increment
        $lastNumber = (int) substr($latestRequest->reqstCODE, 8);
        return "GSO-VR-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
