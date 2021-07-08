<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'usage_id',
        'subscription',
        'cost',
        'fine',
        'total',
        'status'
    ];

    public function usage()
    {
        return $this->belongsTo(Usage::class);
    }
}
