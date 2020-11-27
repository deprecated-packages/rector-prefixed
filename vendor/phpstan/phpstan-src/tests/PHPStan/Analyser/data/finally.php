<?php

namespace _PhpScoperbd5d0c5f7638\FinallyNamespace;

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
    } catch (\_PhpScoperbd5d0c5f7638\FinallyNamespace\FooException $e) {
        $integerOrString = 1;
        $fooOrBarException = $e;
    } catch (\_PhpScoperbd5d0c5f7638\FinallyNamespace\BarException $e) {
        $integerOrString = 'foo';
        $fooOrBarException = $e;
    } finally {
        die;
    }
};
