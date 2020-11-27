<?php

namespace _PhpScoper26e51eeacccf;

function () : void {
    echo $foo ?? 'foo';
    echo $bar->bar ?? 'foo';
};
function (\ReflectionClass $ref) : void {
    echo $ref->name ?? 'foo';
    echo $ref->nonexistent ?? 'bar';
};
