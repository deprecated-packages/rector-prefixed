<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PhpConfigPrinter;

use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
