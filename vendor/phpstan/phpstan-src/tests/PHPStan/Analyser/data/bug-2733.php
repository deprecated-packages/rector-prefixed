<?php

namespace _PhpScoper006a73f0e455\Bug2733;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{id:int, name:string} $data
     */
    public function doSomething(array $data) : void
    {
        foreach (['id', 'name'] as $required) {
            if (!isset($data[$required])) {
                throw new \Exception(\sprintf('Missing data element: %s', $required));
            }
        }
        \PHPStan\Analyser\assertType('array(\'id\' => int, \'name\' => string)', $data);
    }
}
