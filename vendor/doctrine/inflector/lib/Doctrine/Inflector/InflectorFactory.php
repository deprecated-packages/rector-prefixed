<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb\Doctrine\Inflector;

use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\French;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Portuguese;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Spanish;
use _PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScopera143bcca66cb\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScopera143bcca66cb\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScopera143bcca66cb\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScopera143bcca66cb\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScopera143bcca66cb\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
