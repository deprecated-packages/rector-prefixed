<?php

namespace _PhpScoper006a73f0e455\CallToFunctionDoWhileLoop;

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
