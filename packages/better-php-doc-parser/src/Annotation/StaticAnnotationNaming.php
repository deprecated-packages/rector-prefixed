<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Annotation;

final class StaticAnnotationNaming
{
    public static function normalizeName(string $name) : string
    {
        return '@' . \ltrim($name, '@');
    }
}
