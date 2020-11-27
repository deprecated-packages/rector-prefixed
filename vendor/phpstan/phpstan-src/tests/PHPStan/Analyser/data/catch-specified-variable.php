<?php

namespace _PhpScopera143bcca66cb\TryCatchWithSpecifiedVariable;

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
    } catch (\_PhpScopera143bcca66cb\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
