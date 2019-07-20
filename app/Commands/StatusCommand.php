<?php

namespace Laradock\Commands;

use Laradock\Tasks\ParseDockerComposeYaml;
use LaravelZero\Framework\Commands\Command;

class StatusCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'status';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Check the status of your Laradock configuration.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $laradockCompose = \Laradock\invoke(new ParseDockerComposeYaml());

        if (empty($laradockCompose)) {
            $this->info('Looks like you don\'t have a docker-compose.yml setup. Please run ./laradock setup');

            return;
        }

        $this->table(['Service', 'Context'], collect($laradockCompose['services'])->map(function ($service, $key) {
            return [$key, $service['build']['context'] ?? $service['build'] ?? 'Image: '.$service['image']];
        }));

        $this->call('ps');
    }
}
