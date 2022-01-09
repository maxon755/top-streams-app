<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StreamsUpdater\StreamsUpdater;

class UpdateTopStreams extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'streams:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates top 1000 streams from Twitch';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private StreamsUpdater $streamsUpdater)
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
        $this->streamsUpdater->updateStreams();

        return 0;
    }
}
