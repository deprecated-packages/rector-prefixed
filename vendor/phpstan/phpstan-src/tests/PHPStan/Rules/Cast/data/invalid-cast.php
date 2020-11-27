<?php

namespace _PhpScoper26e51eeacccf;

function (string $str) {
    (string) $str;
    (string) new \stdClass();
    (string) new \_PhpScoper26e51eeacccf\Test\ClassWithToString();
    (object) new \stdClass();
    (float) 1.2;
    (int) $str;
    // ok
    (float) $str;
    // ok
    (int) [];
    (int) \true;
    // ok
    (float) \true;
    // ok
    (int) "123";
    // ok
    (int) "blabla";
    (int) new \stdClass();
    (float) new \stdClass();
    (string) \fopen('php://memory', 'r');
    (int) \fopen('php://memory', 'r');
};
function (\_PhpScoper26e51eeacccf\Test\Foo $foo) {
    /** @var object $object */
    $object = \_PhpScoper26e51eeacccf\doFoo();
    (string) $object;
    if (\method_exists($object, '__toString')) {
        (string) $object;
    }
    (string) $foo;
    if (\method_exists($foo, '__toString')) {
        (string) $foo;
    }
    /** @var array|float|int $arrayOrFloatOrInt */
    $arrayOrFloatOrInt = \_PhpScoper26e51eeacccf\doFoo();
    (string) $arrayOrFloatOrInt;
};
function (\SimpleXMLElement $xml) {
    (float) $xml;
    (int) $xml;
    (string) $xml;
    (bool) $xml;
};
function () : void {
    $ch = \curl_init();
    (int) $ch;
};
function () : void {
    $ch = \curl_multi_init();
    (int) $ch;
};
