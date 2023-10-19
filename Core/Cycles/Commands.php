<?php

namespace Core\Cycles;

use Core\Commands\Command;
use Core\Commands\CommandQueue;
use Core\Commands\GuildCommand;
use Core\Disabled;
use Core\InteractionResponder;
use Core\Lifecycle\Runnable;
use PHPCord\PHPCord\Gateway\Event;
use PHPCord\PHPCord\Gateway\Events\Ready;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionApplicationCommandData;
use PHPCord\PHPCord\Parts\Interactions\InteractionType;

class Commands implements Runnable
{
    private CommandQueue $queue;

    public function __construct(
        public bool $registerCommands = true
    )
    {
    }

    public function createQueue(string $appId): void
    {
        $this->queue = new CommandQueue(DISCORD, $appId);

        loopClasses(BOT . '/Commands', function (string $className): void {
            $cmd = new $className();

            if ($cmd instanceof Command && doesClassHaveAttribute($className, Disabled::class) === false) {
                $this->queue->enqueueCommand($cmd);

                LOGGER->debug("Added {$className} to command queue.");
            }
        });
    }

    public function run(): void
    {
        DISCORD->gateway->onEvent(Event::READY, function (Ready $ready) {
            $this->createQueue($ready->application->id);
            $this->listenForInteractions();

            if ($this->registerCommands) {
//                $this->queue->registerCommands()->done();
            }
        });
    }

    public function listenForInteractions(): void
    {
        DISCORD->gateway->onEvent(Event::INTERACTION_CREATE, function (Interaction $interaction) {
            if ($interaction->type !== InteractionType::APPLICATION_COMMAND) {
                return;
            }

            /** @var InteractionApplicationCommandData $data */
            $data = $interaction->data ?? null;

            if (!$data instanceof InteractionApplicationCommandData) {
                return;
            }

            foreach ($this->queue->getQueue() as $command) {
                $commandConfig = $command->getCommand();

                if (
                    $commandConfig->name !== $data->name ||
                    $commandConfig->type !== $data->type ||
                    ($commandConfig instanceof GuildCommand && $commandConfig->getGuildId() !== $interaction->guildId)
                ) {
                    continue;
                }

                break;
            }

            if (!isset($command)) {
                return;
            }

            $command->handle($interaction, new InteractionResponder(DISCORD, $interaction));
        });
    }
}
