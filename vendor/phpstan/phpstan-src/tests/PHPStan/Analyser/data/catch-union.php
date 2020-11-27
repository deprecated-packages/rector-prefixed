<?php

namespace _PhpScoper006a73f0e455\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScoper006a73f0e455\CatchUnion\FooException|\_PhpScoper006a73f0e455\CatchUnion\BarException $e) {
        die;
    }
};
