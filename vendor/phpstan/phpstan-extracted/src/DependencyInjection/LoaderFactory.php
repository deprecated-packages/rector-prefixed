<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\DependencyInjection;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader;
use _PhpScoperb75b35f52b74\PHPStan\File\FileHelper;
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
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\File\FileHelper $fileHelper, string $rootDir, string $currentWorkingDirectory, ?string $generateBaselineFile)
    {
        $this->fileHelper = $fileHelper;
        $this->rootDir = $rootDir;
        $this->currentWorkingDirectory = $currentWorkingDirectory;
        $this->generateBaselineFile = $generateBaselineFile;
    }
    public function createLoader() : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Nette\DI\Config\Loader
    {
        $loader = new \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\NeonLoader($this->fileHelper, $this->generateBaselineFile);
        $loader->addAdapter('dist', \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->addAdapter('neon', \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\NeonAdapter::class);
        $loader->setParameters(['rootDir' => $this->rootDir, 'currentWorkingDirectory' => $this->currentWorkingDirectory]);
        return $loader;
    }
}
