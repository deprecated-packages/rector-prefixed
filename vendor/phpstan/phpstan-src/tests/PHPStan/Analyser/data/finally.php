<?php

namespace _PhpScoper88fe6e0ad041\FinallyNamespace;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
        $integerOrString = 1;
        $fooOrBarException = null;
    } catch (\_PhpScoper88fe6e0ad041\FinallyNamespace\FooException $e) {
        $integerOrString = 1;
        $fooOrBarException = $e;
    } catch (\_PhpScoper88fe6e0ad041\FinallyNamespace\BarException $e) {
        $integerOrString = 'foo';
        $fooOrBarException = $e;
    } finally {
        die;
    }
};