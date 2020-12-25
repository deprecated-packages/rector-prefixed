<?php

declare (strict_types=1);
namespace _PhpScoperbf340cb0be9d\Doctrine\Inflector;

use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\English;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\French;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperbf340cb0be9d\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperbf340cb0be9d\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
