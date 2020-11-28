<?php

namespace _PhpScoperabd03f0baf05\InheritDocConstructors;

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
class Bar extends \_PhpScoperabd03f0baf05\InheritDocConstructors\Foo
{
    public function __construct($name, $data)
    {
        parent::__construct($data);
        \PHPStan\Analyser\assertType('mixed', $name);
        \PHPStan\Analyser\assertType('array<string>', $data);
    }
}
