<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace RectorPrefix20210316\Symfony\Polyfill\Tests\Intl\Icu;

use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentNotImplementedException;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Icu;
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter;
/**
 * Note that there are some values written like -2147483647 - 1. This is the lower 32bit int max and is a known
 * behavior of PHP.
 *
 * @group class-polyfill
 */
class NumberFormatterTest extends \RectorPrefix20210316\Symfony\Polyfill\Tests\Intl\Icu\AbstractNumberFormatterTest
{
    public function testConstructorWithUnsupportedLocale()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        $this->getNumberFormatter('pt_BR');
    }
    public function testConstructorWithUnsupportedStyle()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::PATTERN_DECIMAL);
    }
    public function testConstructorWithPatternDifferentThanNull()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentNotImplementedException::class);
        $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL, '');
    }
    public function testSetAttributeWithUnsupportedAttribute()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->setAttribute(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::LENIENT_PARSE, 100);
    }
    public function testSetAttributeInvalidRoundingMode()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->setAttribute(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::ROUNDING_MODE, -1);
    }
    public function testConstructWithoutLocale()
    {
        $this->assertInstanceOf(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::class, $this->getNumberFormatter(null, \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL));
    }
    public function testCreate()
    {
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $this->assertInstanceOf(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::class, $formatter::create('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL));
    }
    public function testFormatWithCurrencyStyle()
    {
        $this->expectException('RuntimeException');
        parent::testFormatWithCurrencyStyle();
    }
    /**
     * @dataProvider formatTypeInt32Provider
     */
    public function testFormatTypeInt32($formatter, $value, $expected, $message = '')
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        parent::testFormatTypeInt32($formatter, $value, $expected, $message);
    }
    /**
     * @dataProvider formatTypeInt32WithCurrencyStyleProvider
     */
    public function testFormatTypeInt32WithCurrencyStyle($formatter, $value, $expected, $message = '')
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException::class);
        parent::testFormatTypeInt32WithCurrencyStyle($formatter, $value, $expected, $message);
    }
    /**
     * @dataProvider formatTypeInt64Provider
     */
    public function testFormatTypeInt64($formatter, $value, $expected)
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        parent::testFormatTypeInt64($formatter, $value, $expected);
    }
    /**
     * @dataProvider formatTypeInt64WithCurrencyStyleProvider
     */
    public function testFormatTypeInt64WithCurrencyStyle($formatter, $value, $expected)
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException::class);
        parent::testFormatTypeInt64WithCurrencyStyle($formatter, $value, $expected);
    }
    /**
     * @dataProvider formatTypeDoubleProvider
     */
    public function testFormatTypeDouble($formatter, $value, $expected)
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodArgumentValueNotImplementedException::class);
        parent::testFormatTypeDouble($formatter, $value, $expected);
    }
    /**
     * @dataProvider formatTypeDoubleWithCurrencyStyleProvider
     */
    public function testFormatTypeDoubleWithCurrencyStyle($formatter, $value, $expected)
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\NotImplementedException::class);
        parent::testFormatTypeDoubleWithCurrencyStyle($formatter, $value, $expected);
    }
    public function testGetPattern()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->getPattern();
    }
    public function testGetErrorCode()
    {
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $this->assertEquals(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Icu::U_ZERO_ERROR, $formatter->getErrorCode());
    }
    public function testParseCurrency()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $currency = 'USD';
        $formatter->parseCurrency(3, $currency);
    }
    public function testSetPattern()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->setPattern('#0');
    }
    public function testSetSymbol()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->setSymbol(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::GROUPING_SEPARATOR_SYMBOL, '*');
    }
    public function testSetTextAttribute()
    {
        $this->expectException(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Exception\MethodNotImplementedException::class);
        $formatter = $this->getNumberFormatter('en', \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::DECIMAL);
        $formatter->setTextAttribute(\RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter::NEGATIVE_PREFIX, '-');
    }
    protected function getNumberFormatter(?string $locale = 'en', string $style = null, string $pattern = null) : \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter
    {
        return new class($locale, $style, $pattern) extends \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\NumberFormatter
        {
        };
    }
    protected function getIntlErrorMessage() : string
    {
        return \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Icu::getErrorMessage();
    }
    protected function getIntlErrorCode() : int
    {
        return \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Icu::getErrorCode();
    }
    protected function isIntlFailure($errorCode) : bool
    {
        return \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Icu::isFailure($errorCode);
    }
}
