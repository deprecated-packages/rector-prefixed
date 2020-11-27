<?php

namespace _PhpScoper88fe6e0ad041\FinallyNamespace;

try {
    $integerOrString = 1;
    $fooOrBarException = null;
    return 1;
} catch (\_PhpScoper88fe6e0ad041\FinallyNamespace\FooException $e) {
    $integerOrString = 1;
    $fooOrBarException = $e;
    throw $e;
} catch (\_PhpScoper88fe6e0ad041\FinallyNamespace\BarException $e) {
    $integerOrString = 'foo';
    $fooOrBarException = $e;
    return $e;
} finally {
    die;
}
