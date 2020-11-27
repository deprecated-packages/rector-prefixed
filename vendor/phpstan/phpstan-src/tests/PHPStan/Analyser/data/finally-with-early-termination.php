<?php

namespace _PhpScoperbd5d0c5f7638\FinallyNamespace;

try {
    $integerOrString = 1;
    $fooOrBarException = null;
    return 1;
} catch (\_PhpScoperbd5d0c5f7638\FinallyNamespace\FooException $e) {
    $integerOrString = 1;
    $fooOrBarException = $e;
    throw $e;
} catch (\_PhpScoperbd5d0c5f7638\FinallyNamespace\BarException $e) {
    $integerOrString = 'foo';
    $fooOrBarException = $e;
    return $e;
} finally {
    die;
}
