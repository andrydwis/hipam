<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usage extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'meter_cubic',
        'month',
        'year'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function bill()
    {
        return $this->hasOne(Bill::class);
    }
}
