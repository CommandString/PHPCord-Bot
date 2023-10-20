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
use PHPCord\PHPCord\Parts\Guilds\Guild as GuildPart;

class Guild implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {
        $response = new InteractionResponse();
        $response->data = new Message();

        DISCORD->rest->guilds->get($interaction->guildId)->then(function (GuildPart $guild) use ($response, $responder) {
            $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;
            $response->data->embeds = [($embed = new EmbedBuilder())];

            $embed
                ->withAuthor($guild->name, null)
                ->withThumbnail("https://cdn.discordapp.com" + "/icons/guild_id/{$guild->icon}")
                ->withDescription($guild->description ?? '')
                ->withField('Member Count', getMemberCountFromGuild($guild), true)
                ->withField('Bot Count', getBotCountForGuild($guild), true)
                ->withField('Channel Count', $guild->channels->count(), true)
                ->withField('Emoji Count', $guild->emojis->count(), true)
                ->withField('Snowflake', "`{$guild->id}`", true)
                ->withFooter('Created ')
                ->withTimestamp($guild->createdTimestamp());

            var_dump($response->data->embeds[0]);

            $responder->createResponse($response)->done();
        }, function ($e) use ($response, $responder) {
            LOGGER->error($e);
            $response->data->content = 'Cannot find guild.';
            $responder->createResponse($response)->done();
        });
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::CHAT_INPUT;
        $command->name = 'guild';
        $command->description = 'Get information about the current guild';

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
