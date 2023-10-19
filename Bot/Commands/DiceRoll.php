<?php

namespace Bot\Commands;

use Core\Commands\GuildCommand;
use Core\InteractionResponder;
use PHPCord\PHPCord\Builders\MessageBuilder;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommand;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandOption;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandOptionType;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandType;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponseType;

class DiceRoll implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {
        $max = $interaction->data->options[0]->value ?? 6;

        $response = new InteractionResponse();
        $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;
        $response->data = (new MessageBuilder())
            ->withContent('You rolled a **' . random_int(1, $max) . "** on a **{$max}** sided dice 🎲")
            ->build();

        $responder->createResponse($response)->done();
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::CHAT_INPUT;
        $command->name = 'diceroll';
        $command->description = 'Roll some dice';

        $maxOption = new ApplicationCommandOption();
        $maxOption->type = ApplicationCommandOptionType::INTEGER;
        $maxOption->maxValue = 10;
        $maxOption->minValue = 1;
        $maxOption->name = 'max';
        $maxOption->description = 'The maximum number to roll';

        $command->options = [$maxOption];

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
