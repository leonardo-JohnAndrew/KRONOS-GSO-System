<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class purchase_request extends Model
{
    //table 

    protected $table = 'purchase_request';
    protected $fillable = [
        'category',
        'purpose',
        'dateNeeded'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($purchaseRequest) {
            $purchaseRequest->reqstCODE = self::generateNextRequestCoded();
        });
    }


    public static function generateNextRequestCoded()
    {
        $latestRequest = self::where('reqstCODE', 'like', "GSO-PR-%")
            ->orderBy('reqstCODE', 'desc')
            ->first();
        if (!$latestRequest) {
            return "GSO-PR-0001";
        }

        // Extract numeric part and increment
        $lastNumber = (int) substr($latestRequest->reqstCODE, 8);
        return "GSO-PR-" . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}
