<?php

declare (strict_types=1);
namespace Rector\Testing\PhpConfigPrinter;

use RectorPrefix20210212\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use RectorPrefix20210212\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \RectorPrefix20210212\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \RectorPrefix20210212\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\RectorPrefix20210212\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
