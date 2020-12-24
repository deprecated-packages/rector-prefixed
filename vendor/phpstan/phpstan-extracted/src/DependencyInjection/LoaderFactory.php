<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\DependencyInjection;

use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader;
use _PhpScoper0a6b37af0871\PHPStan\File\FileHelper;
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
    public function __construct(\_PhpScoper0a6b37af0871\PHPStan\File\FileHelper $fileHelper, string $rootDir, string $currentWorkingDirectory, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->rootDir = $rootDir;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    public function createLoader() : \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
    {
        $loader = new \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\NeonLoader($this->fileHelper, $this->generateBaselineFile);
        $loader->addAdapter('dist', \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->addAdapter('neon', \_PhpScoper0a6b37af0871\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->setParameters(['rootDir' => $this->rootDir, 'currentWorkingDirectory' => $this->currentWorkingDirectory]);
        return $loader;
    }
}
