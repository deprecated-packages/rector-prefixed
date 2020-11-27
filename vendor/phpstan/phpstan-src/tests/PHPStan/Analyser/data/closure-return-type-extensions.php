<?php

namespace _PhpScoperbd5d0c5f7638\ClosureReturnTypeExtensionsNamespace;

use function PHPStan\Analyser\assertType;
$predicate = function (object $thing) : bool {
    return \true;
};
$closure = \Closure::fromCallable($predicate);
\PHPStan\Analyser\assertType('Closure(object): bool', $closure);
$newThis = new class
{
};
$boundClosure = $closure->bindTo($newThis);
\PHPStan\Analyser\assertType('Closure(object): bool', $boundClosure);
$staticallyBoundClosure = \Closure::bind($closure, $newThis);
\PHPStan\Analyser\assertType('Closure(object): bool', $staticallyBoundClosure);
$returnType = $closure->call($newThis, new class
{
});
\PHPStan\Analyser\assertType('bool', $returnType);
