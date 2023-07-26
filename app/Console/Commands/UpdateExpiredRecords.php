<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Brand;


class UpdateExpiredRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $records = Brand::whereDate('expirations_date', '<=', now())->get();
        foreach ($records as $record) {
            $record->status = 2;
            $record->save();
        }
    }
}