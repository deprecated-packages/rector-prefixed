<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05\Doctrine\Inflector;

use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\English;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\French;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperabd03f0baf05\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperabd03f0baf05\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperabd03f0baf05\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperabd03f0baf05\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
