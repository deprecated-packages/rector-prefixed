<?php

declare (strict_types=1);
namespace RectorPrefix2020DecSat\Doctrine\Inflector;

use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\French;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\NorwegianBokmal;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Portuguese;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Spanish;
use RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \RectorPrefix2020DecSat\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\RectorPrefix2020DecSat\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \RectorPrefix2020DecSat\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::ENGLISH:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::FRENCH:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::PORTUGUESE:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::SPANISH:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \RectorPrefix2020DecSat\Doctrine\Inflector\Language::TURKISH:
                return new \RectorPrefix2020DecSat\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
