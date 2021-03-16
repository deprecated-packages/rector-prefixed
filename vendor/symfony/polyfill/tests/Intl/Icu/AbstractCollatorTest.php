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
use RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Collator;
/**
 * Test case for Collator implementations.
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
abstract class AbstractCollatorTest extends \RectorPrefix20210316\PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider asortProvider
     */
    public function testAsort($array, $sortFlag, $expected)
    {
        $collator = $this->getCollator('en');
        $collator->asort($array, $sortFlag);
        $this->assertSame($expected, $array);
    }
    public function asortProvider()
    {
        return [
            /* array, sortFlag, expected */
            [['a', 'b', 'c'], \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Collator::SORT_REGULAR, ['a', 'b', 'c']],
            [['c', 'b', 'a'], \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Collator::SORT_REGULAR, [2 => 'a', 1 => 'b', 0 => 'c']],
            [['b', 'c', 'a'], \RectorPrefix20210316\Symfony\Polyfill\Intl\Icu\Collator::SORT_REGULAR, [2 => 'a', 0 => 'b', 1 => 'c']],
        ];
    }
    /**
     * @return Collator|\Collator
     */
    protected abstract function getCollator(string $locale);
}
