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
        $bill = new Bill();
        $bill->usage_id = $usage->id;
        $bill->subscription = config('custom.subscription');
        $bill->cost = $usage->meter_cubic * config('custom.cost');
        $bill->total = $bill->subscription + $bill->cost;
        $bill->status = 'unpaid';
        $bill->save();
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
