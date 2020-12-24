<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\PhpConfigPrinter;

use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use _PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\_PhpScoper2a4e7ab1ecbc\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
