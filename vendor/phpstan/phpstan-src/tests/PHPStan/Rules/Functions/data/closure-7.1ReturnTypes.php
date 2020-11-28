<?php

namespace _PhpScoperabd03f0baf05;

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
