<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PhpConfigPrinter;

use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use _PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\_PhpScopere8e811afab72\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
