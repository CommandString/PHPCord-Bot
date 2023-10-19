<?php

use PHPCord\PHPCord\Gateway\Intent;

define('BOT_TOKEN', file_get_contents(BOT_ROOT . '/token.txt'));
define('BOT_INTENTS', [Intent::GUILD_MEMBERS, Intent::GUILD_MESSAGES, Intent::MESSAGE_CONTENT, Intent::GUILDS, Intent::GUILD_PRESENCES]);
define('BOT_GUILD', '988910112825548811');
define('BOT_PREFIX', '??');
