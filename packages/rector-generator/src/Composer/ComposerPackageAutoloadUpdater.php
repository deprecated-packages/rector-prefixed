<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\Composer;

use _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\FileSystem\JsonFileSystem;
use _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\Package;
use _PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\RectorRecipe;
use _PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle;
final class ComposerPackageAutoloadUpdater
{
    /**
     * @var string
     */
    private const PSR_4 = 'psr-4';
    /**
     * @var string
     */
    private const AUTOLOAD = 'autoload';
    /**
     * @var string
     */
    private const AUTOLOAD_DEV = 'autoload-dev';
    /**
     * @var JsonFileSystem
     */
    private $jsonFileSystem;
    /**
     * @var SymfonyStyle
     */
    private $symfonyStyle;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\FileSystem\JsonFileSystem $jsonFileSystem, \_PhpScoper2a4e7ab1ecbc\Symfony\Component\Console\Style\SymfonyStyle $symfonyStyle)
    {
        $this->jsonFileSystem = $jsonFileSystem;
        $this->symfonyStyle = $symfonyStyle;
    }
    public function processComposerAutoload(\_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe) : void
    {
        $composerJsonFilePath = \getcwd() . '/composer.json';
        $composerJson = $this->jsonFileSystem->loadFileToJson($composerJsonFilePath);
        $package = $this->resolvePackage($rectorRecipe);
        if ($this->isPackageAlreadyLoaded($composerJson, $package)) {
            return;
        }
        // ask user
        $questionText = \sprintf('Should we update "composer.json" autoload with "%s" namespace?', $package->getSrcNamespace());
        $isConfirmed = $this->symfonyStyle->confirm($questionText);
        if (!$isConfirmed) {
            return;
        }
        $srcAutoload = $rectorRecipe->isRectorRepository() ? self::AUTOLOAD : self::AUTOLOAD_DEV;
        $composerJson[$srcAutoload][self::PSR_4][$package->getSrcNamespace()] = $package->getSrcDirectory();
        $composerJson[self::AUTOLOAD_DEV][self::PSR_4][$package->getTestsNamespace()] = $package->getTestsDirectory();
        $this->jsonFileSystem->saveJsonToFile($composerJsonFilePath, $composerJson);
        $this->rebuildAutoload();
    }
    private function resolvePackage(\_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\RectorRecipe $rectorRecipe) : \_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\Package
    {
        if (!$rectorRecipe->isRectorRepository()) {
            return new \_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\Package('Utils\\Rector\\', 'Utils\\Rector\\Tests\\', 'utils/rector/src', 'utils/rector/tests');
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\Package('Rector\\' . $rectorRecipe->getPackage() . '\\', 'Rector\\' . $rectorRecipe->getPackage() . '\\Tests\\', 'rules/' . $rectorRecipe->getPackageDirectory() . '/src', 'rules/' . $rectorRecipe->getPackageDirectory() . '/tests');
    }
    /**
     * @param mixed[] $composerJson
     */
    private function isPackageAlreadyLoaded(array $composerJson, \_PhpScoper2a4e7ab1ecbc\Rector\RectorGenerator\ValueObject\Package $package) : bool
    {
        foreach (['autoload', self::AUTOLOAD_DEV] as $autoloadSection) {
            if (isset($composerJson[$autoloadSection][self::PSR_4][$package->getSrcNamespace()])) {
                return \true;
            }
        }
        return \false;
    }
    private function rebuildAutoload() : void
    {
        // note: do not use shell_exec, this is only effective solution for better DX
        \shell_exec('composer dump');
    }
}
