<?php

declare (strict_types=1);
namespace _PhpScoper006a73f0e455;

if (\class_exists('_PhpScoper006a73f0e455\\Mockery')) {
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
        return new \_PhpScoper006a73f0e455\Mockery\DummyMock();
    }
}
\class_alias('_PhpScoper006a73f0e455\\Mockery', 'Mockery', \false);
