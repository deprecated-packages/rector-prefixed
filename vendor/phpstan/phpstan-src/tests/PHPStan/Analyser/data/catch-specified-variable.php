<?php

namespace _PhpScoper26e51eeacccf\TryCatchWithSpecifiedVariable;

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
    } catch (\_PhpScoper26e51eeacccf\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
