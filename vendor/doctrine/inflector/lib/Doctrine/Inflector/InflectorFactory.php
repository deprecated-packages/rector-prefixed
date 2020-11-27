<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Doctrine\Inflector;

use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\French;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperbd5d0c5f7638\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
