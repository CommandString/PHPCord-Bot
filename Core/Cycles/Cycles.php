<?php

namespace App\Lifecycle;

use Core\Cycles\Commands;
use Core\Cycles\Discord;
use Core\Cycles\Events;

return [
    new Discord(),
    new Commands(),
    new Events(),
];
