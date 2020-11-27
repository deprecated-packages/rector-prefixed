<?php

namespace _PhpScopera143bcca66cb\FinallyNamespace;

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
    } catch (\_PhpScopera143bcca66cb\FinallyNamespace\FooException $e) {
        $integerOrString = 1;
        $fooOrBarException = $e;
    } catch (\_PhpScopera143bcca66cb\FinallyNamespace\BarException $e) {
        $integerOrString = 'foo';
        $fooOrBarException = $e;
    } finally {
        die;
    }
};
