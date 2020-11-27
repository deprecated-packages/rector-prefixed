<?php

namespace _PhpScopera143bcca66cb;

function () : void {
    echo $foo ?? 'foo';
    echo $bar->bar ?? 'foo';
};
function (\ReflectionClass $ref) : void {
    echo $ref->name ?? 'foo';
    echo $ref->nonexistent ?? 'bar';
};
