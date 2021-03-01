<?php

declare (strict_types=1);
namespace Rector\SymfonyCodeQuality\Composer;

use RectorPrefix20210301\Nette\Utils\Strings;
use RectorPrefix20210301\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileSystem;
final class ComposerNamespaceMatcher
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    public function __construct(\RectorPrefix20210301\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \RectorPrefix20210301\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->composerJsonFactory = $composerJsonFactory;
    }
    public function matchNamespaceForLocation(string $path) : ?string
    {
        $composerJsonFilePath = \getcwd() . '/composer.json';
        if (!$this->smartFileSystem->exists($composerJsonFilePath)) {
            return null;
        }
        $composerJson = $this->composerJsonFactory->createFromFilePath($composerJsonFilePath);
        $autoload = $composerJson->getAutoload();
        foreach ($autoload['psr-4'] ?? [] as $namespace => $directory) {
            if (!\RectorPrefix20210301\Nette\Utils\Strings::startsWith($path, $directory)) {
                continue;
            }
            return \rtrim($namespace, '\\');
        }
        return null;
    }
}
