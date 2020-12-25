<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace _PhpScoper17db12703726\Symfony\Contracts\Service\Test;

use _PhpScoper17db12703726\PHPUnit\Framework\TestCase;
use _PhpScoper17db12703726\Psr\Container\ContainerInterface;
use _PhpScoper17db12703726\Symfony\Contracts\Service\ServiceLocatorTrait;
abstract class ServiceLocatorTest extends \_PhpScoper17db12703726\PHPUnit\Framework\TestCase
{
    protected function getServiceLocator(array $factories)
    {
        return new class($factories) implements \_PhpScoper17db12703726\Psr\Container\ContainerInterface
        {
            use ServiceLocatorTrait;
        };
    }
    public function testHas()
    {
        $locator = $this->getServiceLocator(['foo' => function () {
            return 'bar';
        }, 'bar' => function () {
            return 'baz';
        }, function () {
            return 'dummy';
        }]);
        $this->assertTrue($locator->has('foo'));
        $this->assertTrue($locator->has('bar'));
        $this->assertFalse($locator->has('dummy'));
    }
    public function testGet()
    {
        $locator = $this->getServiceLocator(['foo' => function () {
            return 'bar';
        }, 'bar' => function () {
            return 'baz';
        }]);
        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame('baz', $locator->get('bar'));
    }
    public function testGetDoesNotMemoize()
    {
        $i = 0;
        $locator = $this->getServiceLocator(['foo' => function () use(&$i) {
            ++$i;
            return 'bar';
        }]);
        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame('bar', $locator->get('foo'));
        $this->assertSame(2, $i);
    }
    public function testThrowsOnUndefinedInternalService()
    {
        if (!$this->getExpectedException()) {
            $this->expectException('_PhpScoper17db12703726\\Psr\\Container\\NotFoundExceptionInterface');
            $this->expectExceptionMessage('The service "foo" has a dependency on a non-existent service "bar". This locator only knows about the "foo" service.');
        }
        $locator = $this->getServiceLocator(['foo' => function () use(&$locator) {
            return $locator->get('bar');
        }]);
        $locator->get('foo');
    }
    public function testThrowsOnCircularReference()
    {
        $this->expectException('_PhpScoper17db12703726\\Psr\\Container\\ContainerExceptionInterface');
        $this->expectExceptionMessage('Circular reference detected for service "bar", path: "bar -> baz -> bar".');
        $locator = $this->getServiceLocator(['foo' => function () use(&$locator) {
            return $locator->get('bar');
        }, 'bar' => function () use(&$locator) {
            return $locator->get('baz');
        }, 'baz' => function () use(&$locator) {
            return $locator->get('bar');
        }]);
        $locator->get('foo');
    }
}
