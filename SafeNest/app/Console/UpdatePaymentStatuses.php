<?php

namespace App\Console\Commands;

use App\Http\Controllers\PaymentController;
use Illuminate\Console\Command;

class UpdatePaymentStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:update-statuses';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update payment statuses and check policy expiry';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating payment statuses...');
        PaymentController::runScheduledChecks();
        $this->info('Payment statuses updated successfully.');
        
        return Command::SUCCESS;
    }
}