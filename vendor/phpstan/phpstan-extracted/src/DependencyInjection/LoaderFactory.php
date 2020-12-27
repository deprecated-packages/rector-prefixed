<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\DependencyInjection;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader;
use RectorPrefix20201227\PHPStan\File\FileHelper;
class LoaderFactory
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var string */
    private $rootDir;
    /** @var string */
    private $currentWorkingDirectory;
    /** @var string|null */
    private $generateBaselineFile;
    public function __construct(\RectorPrefix20201227\PHPStan\File\FileHelper $fileHelper, string $rootDir, string $currentWorkingDirectory, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->rootDir = $rootDir;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    public function createLoader() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
    {
        $loader = new \RectorPrefix20201227\PHPStan\DependencyInjection\NeonLoader($this->fileHelper, $this->generateBaselineFile);
        $loader->addAdapter('dist', \RectorPrefix20201227\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->addAdapter('neon', \RectorPrefix20201227\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->setParameters(['rootDir' => $this->rootDir, 'currentWorkingDirectory' => $this->currentWorkingDirectory]);
        return $loader;
    }
}
