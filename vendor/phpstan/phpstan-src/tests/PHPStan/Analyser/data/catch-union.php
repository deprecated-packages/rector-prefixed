<?php

namespace _PhpScoperabd03f0baf05\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScoperabd03f0baf05\CatchUnion\FooException|\_PhpScoperabd03f0baf05\CatchUnion\BarException $e) {
        die;
    }
};
