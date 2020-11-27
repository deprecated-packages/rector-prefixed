<?php

namespace _PhpScoperbd5d0c5f7638;

function () : void {
    echo $foo ?? 'foo';
    echo $bar->bar ?? 'foo';
};
function (\ReflectionClass $ref) : void {
    echo $ref->name ?? 'foo';
    echo $ref->nonexistent ?? 'bar';
};
