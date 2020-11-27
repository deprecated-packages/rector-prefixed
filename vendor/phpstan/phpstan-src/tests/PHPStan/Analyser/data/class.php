<?php

namespace _PhpScoperbd5d0c5f7638\SomeNodeScopeResolverNamespace;

class InvalidArgumentException extends \Exception
{
}
class Foo
{
    public function doFoo($baz)
    {
        static $staticVariable = [];
        /** @var string $staticVariableWithPhpDocType */
        static $staticVariableWithPhpDocType = 'foo';
        /**
         * @var int $staticVariableWithPhpDocType2
         * @var float $staticVariableWithPhpDocType3
         */
        static $staticVariableWithPhpDocType2 = 100, $staticVariableWithPhpDocType3 = 3.141;
        try {
            foo();
        } catch (\_PhpScoperbd5d0c5f7638\SomeNodeScopeResolverNamespace\InvalidArgumentException $exception) {
            $lorem = 1;
            foreach ($arr as $i => $val) {
                die;
            }
        }
    }
    public function doBar()
    {
    }
}
