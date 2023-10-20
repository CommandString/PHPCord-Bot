<?php

namespace Bot\Commands;

use Core\Builders\EmbedBuilder;
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
class Help implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {
        $response = new InteractionResponse();
        $response->data = new Message();
        $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;
        $response->data->embeds = [($embed = new EmbedBuilder())];

        $embed
            ->withTitle(BOT_APP->name . ' Help')
            ->withDescription('This is a list of all the commands available to you.');

        $responder->createResponse($response)->done();
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::CHAT_INPUT;
        $command->name = 'help';
        $command->description = 'Find out how ' . BOT_APP->name . ' works';

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
