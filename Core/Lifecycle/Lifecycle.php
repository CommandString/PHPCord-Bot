<?php

namespace Core\Lifecycle;

use Core\Exceptions\ApplicationException;
use Core\Exceptions\BotException;

class Lifecycle
{
    private static bool $started = false;

    /**
     * @var Runnable[]
     */
    protected static array $steps = [];

    /**
     * @throws ApplicationException
     */
    private static function throwIfStarted(): void
    {
        if (self::$started) {
            throw new BotException('Bot already booted');
        }
    }

    public static function appendStep(Runnable $step): void
    {
        self::$steps[] = $step;
    }

    public static function appendSteps(Runnable $step, Runnable ...$steps): void
    {
        self::$steps = [...self::$steps, $step, ...$steps];
    }

    public static function start(): void
    {
        self::throwIfStarted();
        self::$started = true;

        while ($step = array_shift(self::$steps)) {
            $step->run();
        }
    }
}
