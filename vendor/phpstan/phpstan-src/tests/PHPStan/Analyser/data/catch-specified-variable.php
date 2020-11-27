<?php

namespace _PhpScoperbd5d0c5f7638\TryCatchWithSpecifiedVariable;

class FooException extends \Exception
{
}
function () {
    /** @var string|null $foo */
    $foo = doFoo();
    if ($foo !== null) {
        return;
    }
    try {
    } catch (\_PhpScoperbd5d0c5f7638\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
