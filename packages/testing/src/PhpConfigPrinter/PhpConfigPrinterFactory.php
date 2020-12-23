<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Testing\PhpConfigPrinter;

use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
