<?php

namespace _PhpScoper006a73f0e455\FinallyNamespace;

try {
    $integerOrString = 1;
    $fooOrBarException = null;
    return 1;
} catch (\_PhpScoper006a73f0e455\FinallyNamespace\FooException $e) {
    $integerOrString = 1;
    $fooOrBarException = $e;
    throw $e;
} catch (\_PhpScoper006a73f0e455\FinallyNamespace\BarException $e) {
    $integerOrString = 'foo';
    $fooOrBarException = $e;
    return $e;
} finally {
    die;
}
