<?php

namespace _PhpScoper006a73f0e455\InheritDocConstructors;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param string[] $data
     */
    public function __construct($data)
    {
        \PHPStan\Analyser\assertType('array<string>', $data);
    }
}
class Bar extends \_PhpScoper006a73f0e455\InheritDocConstructors\Foo
{
    public function __construct($name, $data)
    {
        parent::__construct($data);
        \PHPStan\Analyser\assertType('mixed', $name);
        \PHPStan\Analyser\assertType('array<string>', $data);
    }
}
