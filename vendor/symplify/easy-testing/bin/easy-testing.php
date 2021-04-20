<?php

declare (strict_types=1);
namespace RectorPrefix20210420;

use RectorPrefix20210420\Symplify\EasyTesting\HttpKernel\EasyTestingKernel;
use RectorPrefix20210420\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun;
$possibleAutoloadPaths = [
    // dependency
    __DIR__ . '/../../../autoload.php',
    // after split package
    __DIR__ . '/../vendor/autoload.php',
    // monorepo
    __DIR__ . '/../../../vendor/autoload.php',
];
foreach ($possibleAutoloadPaths as $possibleAutoloadPath) {
    if (\file_exists($possibleAutoloadPath)) {
        require_once $possibleAutoloadPath;
        break;
    }
}
$kernelBootAndApplicationRun = new \RectorPrefix20210420\Symplify\SymplifyKernel\ValueObject\KernelBootAndApplicationRun(\RectorPrefix20210420\Symplify\EasyTesting\HttpKernel\EasyTestingKernel::class);
$kernelBootAndApplicationRun->run();
