<?php

namespace _PhpScoperabd03f0baf05\TryCatchWithSpecifiedVariable;

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
    } catch (\_PhpScoperabd03f0baf05\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
