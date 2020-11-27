<?php

declare (strict_types=1);
namespace _PhpScoper26e51eeacccf;

if (\class_exists('_PhpScoper26e51eeacccf\\Mockery')) {
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
        return new \_PhpScoper26e51eeacccf\Mockery\DummyMock();
    }
}
\class_alias('_PhpScoper26e51eeacccf\\Mockery', 'Mockery', \false);
