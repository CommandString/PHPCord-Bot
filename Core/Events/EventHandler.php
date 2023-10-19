<?php

namespace Core\Events;

use Attribute;
use Core\Exceptions\BotException;
use PHPCord\PHPCord\Gateway\Event;
use PHPCord\PHPCord\Gateway\Events\GuildMemberAdd;
use PHPCord\PHPCord\Gateway\Events\GuildMemberRemove;
use PHPCord\PHPCord\Gateway\Events\MessageCreate;
use PHPCord\PHPCord\Gateway\Events\Ready;
use PHPCord\PHPCord\Gateway\Events\TypingStart;

#[Attribute(Attribute::TARGET_CLASS)]
class EventHandler
{
    /**
     * @var class-string
     */
    public readonly string $eventAbstraction;

    public function __construct(
        public readonly Event $event
    ) {
        $abstraction = match ($event) {
            Event::TYPING_START => TypingStart::class,
            Event::READY => Ready::class,
            Event::GUILD_MEMBER_ADD => GuildMemberAdd::class,
            Event::GUILD_MEMBER_REMOVE => GuildMemberRemove::class,
            Event::MESSAGE_CREATE => MessageCreate::class,
            default => null
        };

        if ($abstraction === null) {
            throw new BotException("Event {$event->name} is not supported.");
        }

        $this->eventAbstraction = $abstraction;
    }
}
