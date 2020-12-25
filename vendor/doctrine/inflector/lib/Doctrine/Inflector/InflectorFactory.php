<?php

declare (strict_types=1);
namespace _PhpScoperfce0de0de1ce\Doctrine\Inflector;

use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\English;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\French;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperfce0de0de1ce\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperfce0de0de1ce\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
