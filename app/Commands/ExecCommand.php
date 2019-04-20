<?php

namespace Laradock\Commands;

use Laradock\Tasks\ParseDotEnvFile;
use Symfony\Component\Process\Process;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use function Laradock\getLaradockCLIEnvPath;

class ExecCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'exec {cmd?* : The docker-compose arguments}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Runs `docker-compose exec` with the `laradock-env` loaded in.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Loading in laradock-env file at: '.getLaradockCLIEnvPath('.laradock-env'));
        $laradockAttributes = \Laradock\invoke(new ParseDotEnvFile(getLaradockCLIEnvPath(), '.laradock-env'));
        $command = 'docker-compose exec ' . implode(' ', $this->input->getArgument('cmd'));
        $process = new Process($command, \Laradock\workingDirectory(), $laradockAttributes, null, 60000);

        $this->info($command);
        $process->run(function ($response, $output) {
            $this->output->write($output);
        });
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}