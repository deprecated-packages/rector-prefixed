<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PhpConfigPrinter;

use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel;
use _PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
final class PhpConfigPrinterFactory
{
    public function create() : \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter
    {
        $phpConfigPrinterKernel = new \_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\HttpKernel\PhpConfigPrinterKernel('prod', \true);
        $phpConfigPrinterKernel->setConfigs([__DIR__ . '/config/php-config-printer-config.php']);
        $phpConfigPrinterKernel->boot();
        $container = $phpConfigPrinterKernel->getContainer();
        return $container->get(\_PhpScoperb75b35f52b74\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter::class);
    }
}
