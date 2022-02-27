<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_type',
        'job_type',
        'assignment_letter_number',
        'name',
        'rt_rw',
        'month',
        'year',
        'technician_id',
    ];

    public function technician()
    {
        return $this->belongsTo(User::class, 'technician_id');
    }
}
