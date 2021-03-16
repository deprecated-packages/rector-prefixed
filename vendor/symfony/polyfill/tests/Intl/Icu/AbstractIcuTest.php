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

use RectorPrefix20210316\PHPUnit\Framework\TestCase;
/**
 * Test case for intl function implementations.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
abstract class AbstractIcuTest extends \RectorPrefix20210316\PHPUnit\Framework\TestCase
{
    public function errorNameProvider()
    {
        return [[-129, '[BOGUS UErrorCode]'], [0, 'U_ZERO_ERROR'], [1, 'U_ILLEGAL_ARGUMENT_ERROR'], [9, 'U_PARSE_ERROR'], [129, '[BOGUS UErrorCode]']];
    }
    /**
     * @dataProvider errorNameProvider
     */
    public function testGetErrorName($errorCode, $errorName)
    {
        $this->assertSame($errorName, $this->getIntlErrorName($errorCode));
    }
    protected abstract function getIntlErrorName($errorCode);
}
