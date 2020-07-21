<?php

declare(strict_types=1);

final class PregReplace
{
    public function run($content)
    {
        return preg_replace('!/\*.*?\*/!s', '', $content);
    }
}
