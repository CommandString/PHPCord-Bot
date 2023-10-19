<?php

namespace Core\Cycles;

use Core\Disabled;
use Core\Events\EventHandler;
use Core\Exceptions\BotException;
use Core\Lifecycle\Runnable;
use ReflectionClass;
use ReflectionException;

class Events implements Runnable
{
    public function run(): void
    {
        loopClasses(BOT . '/Events', function (string $className): void {
            $eventAttrib = doesClassHaveAttribute($className, EventHandler::class);

            if (
                doesClassHaveAttribute($className, Disabled::class) instanceof Disabled ||
                $eventAttrib === false
            ) {
                return;
            }

            $event = new $className();
            $reflection = new ReflectionClass($event);

            $throwInvalidEventHandler = static function () use ($eventAttrib, $event) {
                $name = $eventAttrib->eventAbstraction;
                $shortName = substr($name, strrpos($name, '\\') + 1);
                $eventClass = $event::class;

                throw new BotException("Event Handler {$eventClass} must public function handle({$name} {$shortName}): void");
            };

            try {
                $handleMethod = $reflection->getMethod('handle');
            } catch (ReflectionException) {
                $throwInvalidEventHandler();

                return;
            }

            $paramType = $handleMethod->getParameters()[0]?->getType() ?? null;

            if (
                $paramType === null ||
                $paramType->allowsNull() === true ||
                $paramType->getName() !== $eventAttrib->eventAbstraction
            ) {
                $throwInvalidEventHandler();
            }

            LOGGER->debug("Added {$className} event listener.");
            DISCORD->gateway->onEvent($eventAttrib->event, $event->handle(...));
        });
    }
}
