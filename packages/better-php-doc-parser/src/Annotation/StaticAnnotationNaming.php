<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Annotation;

final class StaticAnnotationNaming
{
    public static function normalizeName(string $name) : string
    {
        return '@' . \ltrim($name, '@');
    }
}
