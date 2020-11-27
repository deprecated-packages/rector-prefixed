<?php

namespace _PhpScoperbd5d0c5f7638\CatchUnion;

class FooException extends \Exception
{
}
class BarException extends \Exception
{
}
function () {
    try {
    } catch (\_PhpScoperbd5d0c5f7638\CatchUnion\FooException|\_PhpScoperbd5d0c5f7638\CatchUnion\BarException $e) {
        die;
    }
};
