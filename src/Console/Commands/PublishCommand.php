<?php

declare(strict_types=1);

namespace Rinvex\Fort\Console\Commands;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rinvex:publish:fort {--force : Overwrite any existing files.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Rinvex Fort Resources.';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->warn($this->description);
        $this->call('vendor:publish', ['--tag' => 'rinvex-fort-config', '--force' => $this->option('force')]);
    }
}