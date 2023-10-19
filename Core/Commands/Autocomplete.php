<?php

namespace Core\Commands;

use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;

interface Autocomplete
{
    public function autocomplete(Interaction $interaction): InteractionResponse;
}
