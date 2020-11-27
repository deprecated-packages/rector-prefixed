<?php

namespace _PhpScoper88fe6e0ad041\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScoper88fe6e0ad041\CatchUnion\FooException|\_PhpScoper88fe6e0ad041\CatchUnion\BarException $e) {
        die;
    }
};
