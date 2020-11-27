<?php

namespace _PhpScoper88fe6e0ad041\CallToFunctionDoWhileLoop;

function requireStdClass(\stdClass $object)
{
}
function () {
    $object = new \stdClass();
    do {
        requireStdClass($object);
    } while ($object = null);
    $object2 = new \stdClass();
    do {
        requireStdClass($object2);
    } while ($object2 === null);
};
