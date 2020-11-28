<?php

namespace _PhpScoperabd03f0baf05\CallToFunctionDoWhileLoop;

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
