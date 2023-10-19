<?php

use Core\Lifecycle\Lifecycle;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

require_once __DIR__ . '/vendor/autoload.php';

// define path constants
const BOT_ROOT = __DIR__;
define('BOT', realpath(BOT_ROOT . '/Bot'));

// create logger
const LOGGER = new Logger('PHPCord', [new StreamHandler('php://stdout')]);

// load core and bot cycles
$coreCycles = require_once BOT . '/Cycles/Cycles.php' ?? [];
$botCycles = require_once BOT_ROOT . '/Core/Cycles/Cycles.php' ?? [];
$cycles = [...$coreCycles, ...$botCycles];

if (empty($cycles)) {
    throw new BotException('No cycles found.');
}

// run cycles
Lifecycle::appendSteps(...$cycles);
Lifecycle::start();

// start gateway connection
DISCORD->gateway->start();
