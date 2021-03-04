<?php

declare (strict_types=1);
namespace Rector\Testing\Configuration;

use Rector\Testing\Finder\RectorsFinder;
use Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory;
use RectorPrefix20210304\Symplify\PhpConfigPrinter\Printer\SmartPhpConfigPrinter;
use RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileSystem;
final class AllRectorConfigFactory
{
    /**
     * @var RectorsFinder
     */
    private $rectorsFinder;
    /**
     * @var SmartPhpConfigPrinter
     */
    private $smartPhpConfigPrinter;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var string
     */
    private $configFilePath;
    public function __construct()
    {
        $this->rectorsFinder = new \Rector\Testing\Finder\RectorsFinder();
        $this->smartFileSystem = new \RectorPrefix20210304\Symplify\SmartFileSystem\SmartFileSystem();
        $phpConfigPrinterFactory = new \Rector\Testing\PhpConfigPrinter\PhpConfigPrinterFactory();
        $this->smartPhpConfigPrinter = $phpConfigPrinterFactory->create();
        $this->configFilePath = \sys_get_temp_dir() . '/_rector_tests/all_rectors_config.php';
    }
    public function create() : string
    {
        $rectorClasses = $this->rectorsFinder->findCoreRectorClasses();
        $services = \array_fill_keys($rectorClasses, null);
        $allRectorsContent = $this->smartPhpConfigPrinter->printConfiguredServices($services);
        $this->smartFileSystem->dumpFile($this->configFilePath, $allRectorsContent);
        return $this->configFilePath;
    }
}
