<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Doctrine\Inflector;

use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\English;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\French;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Portuguese;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Spanish;
use _PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScoperb75b35f52b74\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScoperb75b35f52b74\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScoperb75b35f52b74\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScoperb75b35f52b74\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
