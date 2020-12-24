<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Annotation;

final class StaticAnnotationNaming
{
    public static function normalizeName(string $name) : string
    {
        return '@' . \ltrim($name, '@');
    }
}
