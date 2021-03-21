<?php

declare(strict_types=1);

namespace App;

use Composer\Script\Event;
use FilesystemIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class Installer
{
    public static function postUpdate(Event $event = null): void
    {
        self::chmodRecursive('runtime', 0777);
        self::chmodRecursive('public/assets', 0777);
    }

    private static function chmodRecursive(string $path, int $mode): void
    {
        chmod($path, $mode);
        $flags = FilesystemIterator::SKIP_DOTS | FilesystemIterator::CURRENT_AS_PATHNAME;

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, $flags),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            chmod($item, $mode);
        }
    }
}
