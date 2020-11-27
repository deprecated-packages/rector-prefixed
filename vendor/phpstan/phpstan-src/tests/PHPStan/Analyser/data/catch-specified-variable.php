<?php

namespace _PhpScoper88fe6e0ad041\TryCatchWithSpecifiedVariable;

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
    } catch (\_PhpScoper88fe6e0ad041\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
