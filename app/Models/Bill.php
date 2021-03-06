<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'usage_id',
        'meter_cubic',
        'subscription',
        'cost',
        'fine',
        'total',
        'status',
        'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function usage()
    {
        return $this->belongsTo(Usage::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }

    public function allArrears($client_id)
    {
        $currentBillCreatedAt = $this->created_at;
        $arrearsCount = Bill::where('created_at', '<=', $currentBillCreatedAt)->where('status', 'late')->whereHas('usage', function ($query) use ($client_id) {
            return $query->where('client_id', $client_id);
        })->get()->count();

        return $arrearsCount;
    }
}
