<?php

namespace Core\Cycles;

use Core\Lifecycle\Runnable;
use Discord\Http\Drivers\Guzzle;
use PHPCord\PHPCord\Discord as PHPCord;
use PHPCord\PHPCord\Parts\Application;
use PHPCord\PHPCord\Parts\Users\User;

use function React\Promise\all;

class Discord implements Runnable
{
    public function run(): void
    {
        define('DISCORD', new PHPCord(BOT_TOKEN, LOGGER));
        DISCORD->withRest(new Guzzle(options: ['verify' => false]));
        DISCORD->withGateway();
        DISCORD->gateway->withIntents(...BOT_INTENTS);
        $this->createBotConstants();
    }

    public function createBotConstants(): void
    {
        all([
            DISCORD->rest->users->getCurrent()->then(
                static fn (User $user) => define('BOT_USER', $user)
            ),
            DISCORD->rest->application->getCurrent()->then(
                static fn (Application $application) => define('BOT_APP', $application)
            ),
        ])->done();
    }
}
