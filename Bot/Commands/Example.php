<?php

namespace Bot\Commands;

use Core\Commands\GuildCommand;
use Core\Disabled;
use Core\InteractionResponder;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommand;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandType;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponseType;
use PHPCord\PHPCord\Parts\Messages\Message;

#[Disabled]
class Example implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {
        $response = new InteractionResponse();
        $response->data = new Message();
        $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;
        $response->data->content = 'Hello World!';

        $responder->createResponse($response)->done();
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::CHAT_INPUT;
        $command->name = 'name';
        $command->description = 'desc';

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
