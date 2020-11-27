<?php

namespace _PhpScoper26e51eeacccf\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScoper26e51eeacccf\CatchUnion\FooException|\_PhpScoper26e51eeacccf\CatchUnion\BarException $e) {
        die;
    }
};
