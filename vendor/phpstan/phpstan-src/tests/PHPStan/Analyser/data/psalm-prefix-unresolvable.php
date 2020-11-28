<?php

namespace _PhpScoperabd03f0baf05\PsalmPrefixedTagsWithUnresolvableTypes;

use function PHPStan\Analyser\assertType;
class Foo
{
    /**
     * @return array<int, string>
     * @psalm-return list<string>
     */
    public function doFoo()
    {
        return [];
    }
    public function doBar() : void
    {
        \PHPStan\Analyser\assertType('array<int, string>', $this->doFoo());
    }
    /**
     * @param Foo $param
     * @param Foo $param2
     * @psalm-param foo-bar $param
     * @psalm-param foo-bar<Test> $param2
     */
    public function doBaz($param, $param2)
    {
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\PsalmPrefixedTagsWithUnresolvableTypes\\Foo', $param);
        \PHPStan\Analyser\assertType('_PhpScoperabd03f0baf05\\PsalmPrefixedTagsWithUnresolvableTypes\\Foo', $param2);
    }
}
