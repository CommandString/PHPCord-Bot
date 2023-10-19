<?php

namespace Core\Commands;

use PHPCord\PHPCord\Discord;
use React\Promise\PromiseInterface;

use function React\Promise\all;

class CommandQueue
{
    /** @var Command[] */
    private array $queue;

    public function __construct(
        private readonly Discord $discord,
        private readonly string $applicationId
    ) {
        $this->queue = [];
    }

    public function enqueueCommand(Command $command): void
    {
        $this->queue[] = $command;
    }

    public function getQueue(): array
    {
        return $this->queue;
    }

    public function registerCommands(): PromiseInterface
    {
        $guildCommands = [];
        $globalCommands = [];
        $addGuildCommand = static function (GuildCommand $command) use (&$guildCommands): void {
            if (!isset($guildCommands[$command->getGuildId()])) {
                $guildCommands[$command->getGuildId()] = [];
            }

            $guildCommands[$command->getGuildId()][] = $command->getCommand();
        };

        foreach ($this->queue as $command) {
            if ($command instanceof GuildCommand) {
                $addGuildCommand($command);
            } else {
                $globalCommands[] = $command->getCommand();
            }
        }

        $register = [];

        foreach ($guildCommands as $guildId => $commands) {
            $register[] = $this->discord->rest->guildCommands->bulkOverwriteCommands($this->applicationId, $guildId, ...$commands);
        }

        $register[] = $this->discord->rest->globalCommands->bulkOverwriteCommands($this->applicationId, ...$globalCommands);

        return all($register);
    }
}
