<?php

namespace _PhpScoper88fe6e0ad041;

function () : ?int {
    return 1;
};
function () : ?int {
    return 'foo';
};
function () : ?int {
    return null;
};
function () : iterable {
    return [];
};
function () : iterable {
    return 'foo';
};
function () : iterable {
    return new \ArrayIterator([]);
};
function () : void {
    return;
};
