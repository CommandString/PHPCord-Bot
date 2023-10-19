<?php

namespace Bot\Commands;

use Core\Builders\EmbedBuilder;
use Core\Commands\GuildCommand;
use Core\InteractionResponder;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommand;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandType;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponseType;
use PHPCord\PHPCord\Parts\Messages\Message;

class Status implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {
        $response = new InteractionResponse();
        $response->data = new Message();
        $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;
        $response->data->embeds = [
            (new EmbedBuilder())
                ->withTitle(BOT_USER->username . '#' . BOT_USER->discriminator ?? '')
                ->withDescription(BOT_APP->description ?? '*No description*')
                ->withColor(0xFFD700)
                ->withField('Bot Started', '<t:' . BOT_START . ':R>'  ?? 'unknown', true)
                ->withField('Guilds', BOT_APP->approximateGuildCount ?? 'unknown', true)
                ->withField('Memory Usage', round(memory_get_usage() / 1024 / 1024, 2) . ' MB', true)
                ->withField('Memory Peak Usage', round(memory_get_peak_usage() / 1024 / 1024, 2) . ' MB', true)
                ->withField('PHP Version', phpversion(), true)
                ->withField('PHP OS', PHP_OS_FAMILY, true)
                ->withFooter('Created by ' . BOT_APP->owner->globalName)
                ->build(),
        ];

        $responder->createResponse($response)->done();
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::CHAT_INPUT;
        $command->name = 'status';
        $command->description = 'Get the status of the bot';

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
