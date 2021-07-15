<?php

namespace App\Observers;

use App\Models\Bill;
use App\Models\Usage;

class UsageObserver
{
    /**
     * Handle the Usage "created" event.
     *
     * @param  \App\Models\Usage  $usage
     * @return void
     */
    public function created(Usage $usage)
    {
        //
        if ($usage->month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $usage->year - 1)->first();
        } elseif ($usage->month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $usage->year)->first();
        }

        if ($last) {
            $meters = $usage->meter_cubic - $last->meter_cubic;

            $bill = new Bill();
            $bill->usage_id = $usage->id;
            $bill->meter = $meters;
            $bill->subscription = config('custom.subscription');
            $bill->cost = $meters * config('custom.cost');
            $bill->total = $bill->subscription + $bill->cost;
            $bill->status = 'unpaid';
            $bill->save();
        }
    }

    /**
     * Handle the Usage "updated" event.
     *
     * @param  \App\Models\Usage  $usage
     * @return void
     */
    public function updated(Usage $usage)
    {
        //
        if ($usage->month == 'Januari') {
            $last = Usage::where('month', 'Desember')->where('year', $usage->year - 1)->first();
        } elseif ($usage->month == 'Februari') {
            $last = Usage::where('month', 'Januari')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Maret') {
            $last = Usage::where('month', 'Februari')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'April') {
            $last = Usage::where('month', 'Maret')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Mei') {
            $last = Usage::where('month', 'April')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Juni') {
            $last = Usage::where('month', 'Mei')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Juli') {
            $last = Usage::where('month', 'Juni')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Agustus') {
            $last = Usage::where('month', 'Juli')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'September') {
            $last = Usage::where('month', 'Agustus')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Oktober') {
            $last = Usage::where('month', 'September')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'November') {
            $last = Usage::where('month', 'Oktober')->where('year', $usage->year)->first();
        } elseif ($usage->month == 'Desember') {
            $last = Usage::where('month', 'November')->where('year', $usage->year)->first();
        }

        if ($last) {
            $meters = $usage->meter_cubic - $last->meter_cubic;

            $bill = Bill::where('usage_id', $usage->id)->first();
            $bill->usage_id = $usage->id;
            $bill->meter = $meters;
            $bill->subscription = config('custom.subscription');
            $bill->cost = $meters * config('custom.cost');
            $bill->total = $bill->subscription + $bill->cost + ($bill->fine ?? 0);
            $bill->save();
        }
    }

    /**
     * Handle the Usage "deleted" event.
     *
     * @param  \App\Models\Usage  $usage
     * @return void
     */
    public function deleted(Usage $usage)
    {
        //
    }

    /**
     * Handle the Usage "restored" event.
     *
     * @param  \App\Models\Usage  $usage
     * @return void
     */
    public function restored(Usage $usage)
    {
        //
    }

    /**
     * Handle the Usage "force deleted" event.
     *
     * @param  \App\Models\Usage  $usage
     * @return void
     */
    public function forceDeleted(Usage $usage)
    {
        //
    }
}
