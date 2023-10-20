<?php

namespace Bot\Commands;

use PHPCord\PHPCord\Parts\Commands\ApplicationCommand;
use PHPCord\PHPCord\Parts\Commands\ApplicationCommandType;
use PHPCord\PHPCord\Parts\Guilds\Member;
use PHPCord\PHPCord\Parts\Interactions\Interaction;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponse;
use PHPCord\PHPCord\Parts\Interactions\InteractionResponseType;
use PHPCord\PHPCord\Parts\Messages\Message;
use PHPCord\PHPCord\Parts\Users\User;
use Core\Builders\EmbedBuilder;
use Core\Commands\GuildCommand;
use Core\InteractionResponder;
use function React\Async\await;

class ViewProfile implements GuildCommand
{
    public function handle(Interaction $interaction, InteractionResponder $responder): void
    {

        $response = new InteractionResponse();
        $response->data = new Message();
        $response->type = InteractionResponseType::CHANNEL_MESSAGE_WITH_SOURCE;

        $failed = static function () use ($response, $responder) {
            $response->data->content = 'Cannot find user.';
            $responder->createResponse($response)->done();
        };

        $resolvedUser = array_keys($interaction->data->resolved->users ?? [])[0] ?? null;
        $resolvedMember = array_keys($interaction->data->resolved->members ?? [])[0] ?? null;

        if ($resolvedUser === null && $resolvedMember === null) {
            $failed();
            return;
        }

        $user = $member = null;

        /** @var Member|null $user */
        $member = $interaction->data->resolved->members[$resolvedMember] ?? null;

        /** @var User|null $user */
        $user = $interaction->data->resolved->users[$resolvedUser] ?? null;

        if ($user === null && $member === null) {
            $failed();
            return;
        }

        $profile = (new EmbedBuilder());

        if ($member instanceof Member) {
            $profile->withField('Nickname', $member->nick ?? 'None', true);
        } else {
            $profile = (new EmbedBuilder());
        }

        var_dump($user);

        $profile
            ->withTitle($user->globalName ?? "{$user->username}#{$user->discriminator}")
            ->withField('Joined Discord', '<t:' . $user->id->getTime() . ':R>', true)
        ;

        $response->data->embeds = [$profile->build()];

        $responder->createResponse($response)->done();
    }

    public function getCommand(): ApplicationCommand
    {
        $command = new ApplicationCommand();
        $command->type = ApplicationCommandType::USER;
        $command->name = 'View Profile';

        return $command;
    }

    public function getGuildId(): string
    {
        return BOT_GUILD;
    }
}
