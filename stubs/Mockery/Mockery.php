<?php

declare (strict_types=1);
namespace _PhpScoperabd03f0baf05;

if (\class_exists('_PhpScoperabd03f0baf05\\Mockery')) {
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
        return new \_PhpScoperabd03f0baf05\Mockery\DummyMock();
    }
}
\class_alias('_PhpScoperabd03f0baf05\\Mockery', 'Mockery', \false);
