<?php

namespace Laradock\DockerCommands;

use Laradock\Service\DockerComposeCommand;

class WorkspaceCommand extends DockerComposeCommand
{
    public $tty = true;

    public $command = 'docker-compose exec --user=laradock workspace zsh';

    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'workspace {cmd?* : The docker-compose arguments}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Mounts yourself to the workspace container as Laradock user';
}
