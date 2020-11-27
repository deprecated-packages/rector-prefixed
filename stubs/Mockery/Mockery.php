<?php

declare (strict_types=1);
namespace _PhpScoper88fe6e0ad041;

if (\class_exists('_PhpScoper88fe6e0ad041\\Mockery')) {
    return;
}
class Mockery
{
    /**
     * @param mixed ...$args
     *
     * @return \Mockery\MockInterface
     */
    public static function mock(...$args)
    {
        return new \_PhpScoper88fe6e0ad041\Mockery\DummyMock();
    }
}
\class_alias('_PhpScoper88fe6e0ad041\\Mockery', 'Mockery', \false);
