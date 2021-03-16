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
 * Test case for Locale implementations.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
abstract class AbstractLocaleTest extends \RectorPrefix20210316\PHPUnit\Framework\TestCase
{
    public function testSetDefault()
    {
        $this->call('setDefault', 'en_GB');
        $this->assertSame('en_GB', $this->call('getDefault'));
    }
    protected abstract function call($methodName);
}
