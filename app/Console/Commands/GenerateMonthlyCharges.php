<?php

namespace App\Console\Commands;

use App\Models\Charge;
use App\Models\RecurringCharge;
use Illuminate\Console\Command;

class GenerateMonthlyCharges extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-monthly-charges';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gera cobranças baseadas em cobranças recorrentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->day;

        RecurringCharge::where('due_day', $today)
            ->where('active', true)
            ->each(function ($rc) {
                Charge::create([
                    'organization_id' => $rc->organization_id,
                    'description' => $rc->description,
                    'amount' => $rc->amount,
                    'due_date' => now()->startOfMonth()->addDays($rc->due_day - 1),
                    'status' => 'pending',
                ]);
            });

        $this->info('Cobranças recorrentes geradas com sucesso!');
    }
}
