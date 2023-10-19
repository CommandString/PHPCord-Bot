<?php

use CommandString\Utils\FileSystemUtils;

/**
 * Loop through all the classes in a directory and call a callback function with the class name\
 *
 * @param string $directory The directory to loop through
 * @param callable $callback function (string $className, string $namespace, string $file, string $path): void
 */
function loopClasses(string $directory, callable $callback): void
{
    $convertPathToNamespace = static fn (string $path): string => str_replace([realpath(BOT_ROOT), '/'], ['', '\\'], $path);

    foreach (FileSystemUtils::getAllFiles($directory, true) as $file) {
        if (!str_ends_with($file, '.php')) {
            continue;
        }

        $className = basename($file, '.php');
        $path = dirname($file);
        $namespace = $convertPathToNamespace($path);
        $className = $namespace . '\\' . $className;

        $callback($className, $namespace, $file, $path);
    }
}

/**
 * @template T
 *
 * @param class-string $class
 * @param class-string<T> $attribute
 *
 * @throws ReflectionException
 *
 * @return T|false
 */
function doesClassHaveAttribute(string $class, string $attribute): object|false
{
    $attrib = (new ReflectionClass($class))->getAttributes($attribute, ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;

    return $attrib === null ? false : $attrib->newInstance();
}
