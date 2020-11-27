<?php

namespace _PhpScopera143bcca66cb\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScopera143bcca66cb\CatchUnion\FooException|\_PhpScopera143bcca66cb\CatchUnion\BarException $e) {
        die;
    }
};
