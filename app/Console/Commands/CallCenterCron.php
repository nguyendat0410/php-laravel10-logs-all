<?php

namespace App\Console\Commands;

use Core\CallCenter\CallCenter;
use Illuminate\Console\Command;

class CallCenterCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:call-center-cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Call center cron job !!!';
    private CallCenter $callCenter;

    function __construct(CallCenter $callcenter)
    {
        $this->callCenter = $callcenter;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->callCenter->logs();
    }
}
