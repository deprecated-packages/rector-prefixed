<?php

declare (strict_types=1);
namespace _PhpScoperf18a0c41e2d2\Doctrine\Inflector;

use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\English;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\French;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperf18a0c41e2d2\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
