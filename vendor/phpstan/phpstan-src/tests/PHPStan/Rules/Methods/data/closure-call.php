<?php

namespace _PhpScoper006a73f0e455\ClosureCall;

$newThis = new class
{
};
$thing = new class
{
};
$predicate = function (object $thing) : bool {
    return \true;
};
$predicate->call();
$predicate->call($newThis);
$predicate->call(42);
$predicate->call($newThis, 42);
$predicate->call(42, $thing);
$predicate->call($newThis, $thing, 42);
$result = $predicate->call($newThis, $thing);
$operation = function (object $thing) : void {
};
$voidResult = $operation->call($newThis, $thing);
