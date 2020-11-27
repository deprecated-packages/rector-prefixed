<?php

namespace _PhpScoper006a73f0e455\TryCatchWithSpecifiedVariable;

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
    } catch (\_PhpScoper006a73f0e455\TryCatchWithSpecifiedVariable\FooException $foo) {
        die;
    }
};
