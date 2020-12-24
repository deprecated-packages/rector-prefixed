<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc;

use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\HttpKernel\RuleDocGeneratorKernel;
use _PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
# 1. autoload
$possibleAutoloadPaths = [
    // after split package
    __DIR__ . '/../vendor/autoload.php',
    // dependency
    __DIR__ . '/../../../autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$extraConfigs = [];
$extraConfig = \getcwd() . '/rule-doc-generator.php';
if (\file_exists($extraConfig)) {
    $extraConfigs[] = $extraConfig;
}
$kernelBootAndApplicationRun = new \_PhpScoper2a4e7ab1ecbc\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\HttpKernel\RuleDocGeneratorKernel::class, $extraConfigs);
$kernelBootAndApplicationRun->run();
