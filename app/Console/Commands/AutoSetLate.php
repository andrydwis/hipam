<?php

namespace App\Console\Commands;

use App\Models\Bill;
use Illuminate\Console\Command;

class AutoSetLate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:late';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Auto set late all bills that status is unpaid';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bills = Bill::where('status', 'unpaid')->get();
        foreach ($bills as $bill) {
            $bill->fine = config('custom.fine');
            $bill->total = $bill->total + config('custom.fine');
            $bill->status = 'late';
            $bill->save();
        }
        return 'success set all bills to late status';
    }
}
