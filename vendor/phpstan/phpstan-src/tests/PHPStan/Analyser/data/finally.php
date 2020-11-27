<?php

namespace _PhpScoper006a73f0e455\FinallyNamespace;

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
    } catch (\_PhpScoper006a73f0e455\FinallyNamespace\FooException $e) {
        $integerOrString = 1;
        $fooOrBarException = $e;
    } catch (\_PhpScoper006a73f0e455\FinallyNamespace\BarException $e) {
        $integerOrString = 'foo';
        $fooOrBarException = $e;
    } finally {
        die;
    }
};
