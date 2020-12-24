<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Annotation;

final class StaticAnnotationNaming
{
    public static function normalizeName(string $name) : string
    {
        return '@' . \ltrim($name, '@');
    }
}
