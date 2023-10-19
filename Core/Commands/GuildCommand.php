<?php

namespace Core\Commands;

interface GuildCommand extends Command
{
    public function getGuildId(): string;
}
