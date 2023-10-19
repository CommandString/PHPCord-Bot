<?php

namespace Core\Commands;

use Core\InteractionResponder;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommand;
use PHPCord\PHPCord\Parts\Interactions\Interaction;

interface Command
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void;

    public function getCommand(): ApplicationCommand;
}
