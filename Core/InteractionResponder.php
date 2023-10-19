<?php

namespace Core;

use PHPCord\PHPCord\Discord;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;
use PHPCord\PHPCord\Parts\Messages\Message;
use React\Promise\PromiseInterface;

class InteractionResponder
{
    public function __construct(
        public readonly Discord $bot,
        private readonly Interaction $interaction
    ) {
    }

    public function createResponse(InteractionResponse $response): PromiseInterface
    {
        return $this->bot->rest->interactions->createResponse($this->interaction->id, $this->interaction->token, $response);
    }

    public function getResponse(): PromiseInterface
    {
        return $this->bot->rest->interactions->getResponse($this->interaction->id, $this->interaction->token);
    }

    public function editResponse(Message $message): PromiseInterface
    {
        return $this->bot->rest->interactions->editResponse($this->interaction->id, $this->interaction->token, $message);
    }

    public function deleteResponse(): PromiseInterface
    {
        return $this->bot->rest->interactions->deleteResponse($this->interaction->id, $this->interaction->token);
    }

    public function createFollowup(Message $message): PromiseInterface
    {
        return $this->bot->rest->interactions->createFollowup($this->interaction->id, $this->interaction->token, $message);
    }

    public function getFollowup(string $messageId): PromiseInterface
    {
        return $this->bot->rest->interactions->getFollowup($this->interaction->id, $this->interaction->token, $messageId);
    }

    public function editFollowup(string $messageId, Message $message): PromiseInterface
    {
        return $this->bot->rest->interactions->editFollowup($this->interaction->id, $this->interaction->token, $messageId, $message);
    }

    public function deleteFollowup(string $messageId): PromiseInterface
    {
        return $this->bot->rest->interactions->deleteFollowup($this->interaction->id, $this->interaction->token, $messageId);
    }
}
