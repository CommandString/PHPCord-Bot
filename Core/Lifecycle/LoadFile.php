<?php

namespace Core\Lifecycle;

use Core\Exceptions\BotException;

class LoadFile implements Runnable
{
    public readonly string $path;

    public function __construct(
        string $path
    ) {
        $realPath = realpath($path);

        if (!$realPath) {
            throw new BotException("File {$path} does not exist.");
        }

        $this->path = $realPath;
    }

    public function run(): void
    {
        require_once $this->path;
    }
}
