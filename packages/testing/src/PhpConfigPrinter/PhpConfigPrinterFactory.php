<?php

declare (strict_types=1);
namespace Rector\Testing\PhpConfigPrinter;

use Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
