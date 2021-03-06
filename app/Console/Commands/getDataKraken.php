<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class getDataKraken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kraken:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Balance & Market value from kraken API';

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
        $user = User::all();
        foreach ($user as $k => $d) {
            event(new \App\Events\loadDataKraken($d->id));
        }
    }
}