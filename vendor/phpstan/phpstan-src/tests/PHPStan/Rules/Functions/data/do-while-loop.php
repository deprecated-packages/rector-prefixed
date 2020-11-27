<?php

namespace _PhpScopera143bcca66cb\CallToFunctionDoWhileLoop;

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
