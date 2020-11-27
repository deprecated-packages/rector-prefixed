<?php

declare (strict_types=1);
namespace PHPStan\DependencyInjection;

use _PhpScoper26e51eeacccf\Nette\DI\Config\Loader;
use PHPStan\File\FileHelper;
class LoaderFactory
{
    /**
     * @var \PHPStan\File\FileHelper
     */
    private $fileHelper;
    /**
     * @var string
     */
    private $rootDir;
    /**
     * @var string
     */
    private $currentWorkingDirectory;
    /**
     * @var string|null
     */
    private $generateBaselineFile;
    public function __construct(\PHPStan\File\FileHelper $fileHelper, string $rootDir, string $currentWorkingDirectory, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->rootDir = $rootDir;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    public function createLoader() : \_PhpScoper26e51eeacccf\Nette\DI\Config\Loader
    {
        $loader = new \PHPStan\DependencyInjection\NeonLoader($this->fileHelper, $this->generateBaselineFile);
        $loader->addAdapter('dist', \PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->addAdapter('neon', \PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->setParameters(['rootDir' => $this->rootDir, 'currentWorkingDirectory' => $this->currentWorkingDirectory]);
        return $loader;
    }
}
