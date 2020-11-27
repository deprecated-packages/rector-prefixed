<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638;

if (\class_exists('_PhpScoperbd5d0c5f7638\\Mockery')) {
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
        return new \_PhpScoperbd5d0c5f7638\Mockery\DummyMock();
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\Mockery', 'Mockery', \false);
