<?php

namespace _PhpScoper26e51eeacccf\ArrayShapeKeysStrings;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @param array{
     *  'namespace/key': string
     * } $slash
     * @param array<int, array{
     *   "$ref": string
     * }> $dollar
     */
    public function doFoo(array $slash, array $dollar) : void
    {
        \PHPStan\Analyser\assertType("array('namespace/key' => string)", $slash);
        \PHPStan\Analyser\assertType('array<int, array(\'$ref\' => string)>', $dollar);
    }
}
