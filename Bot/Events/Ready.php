<?php

namespace Bot\Events;

use Core\Events\EventHandler;
use PHPCord\PHPCord\Gateway\Event;
use PHPCord\PHPCord\Gateway\Events\Ready as ReadyEvent;

#[EventHandler(Event::READY)]
class Ready
{
    public function handle(ReadyEvent $ready): void
    {
        define('BOT_START', time());
        LOGGER->info('Bot is ready!');
    }
}
