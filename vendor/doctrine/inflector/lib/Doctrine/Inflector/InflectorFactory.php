<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Doctrine\Inflector;

use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\English;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\French;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\NorwegianBokmal;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Portuguese;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish;
use _PhpScopere8e811afab72\Doctrine\Inflector\Rules\Turkish;
use InvalidArgumentException;
use function sprintf;
final class InflectorFactory
{
    public static function create() : \_PhpScopere8e811afab72\Doctrine\Inflector\LanguageInflectorFactory
    {
        return self::createForLanguage(\_PhpScopere8e811afab72\Doctrine\Inflector\Language::ENGLISH);
    }
    public static function createForLanguage(string $language) : \_PhpScopere8e811afab72\Doctrine\Inflector\LanguageInflectorFactory
    {
        switch ($language) {
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::ENGLISH:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\English\InflectorFactory();
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::FRENCH:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\French\InflectorFactory();
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::NORWEGIAN_BOKMAL:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\NorwegianBokmal\InflectorFactory();
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::PORTUGUESE:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Portuguese\InflectorFactory();
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::SPANISH:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Spanish\InflectorFactory();
            case \_PhpScopere8e811afab72\Doctrine\Inflector\Language::TURKISH:
                return new \_PhpScopere8e811afab72\Doctrine\Inflector\Rules\Turkish\InflectorFactory();
            default:
                throw new \InvalidArgumentException(\sprintf('Language "%s" is not supported.', $language));
        }
    }
}
