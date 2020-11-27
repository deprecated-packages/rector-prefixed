<?php

namespace _PhpScopera143bcca66cb\FinallyNamespace;

try {
    $integerOrString = 1;
    $fooOrBarException = null;
    return 1;
} catch (\_PhpScopera143bcca66cb\FinallyNamespace\FooException $e) {
    $integerOrString = 1;
    $fooOrBarException = $e;
    throw $e;
} catch (\_PhpScopera143bcca66cb\FinallyNamespace\BarException $e) {
    $integerOrString = 'foo';
    $fooOrBarException = $e;
    return $e;
} finally {
    die;
}
