<?php

declare (strict_types=1);
namespace _PhpScopera143bcca66cb;

if (\class_exists('_PhpScopera143bcca66cb\\Mockery')) {
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
        return new \_PhpScopera143bcca66cb\Mockery\DummyMock();
    }
}
\class_alias('_PhpScopera143bcca66cb\\Mockery', 'Mockery', \false);
