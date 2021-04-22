<?php

declare (strict_types=1);
namespace Rector\Symfony\Composer;

use RectorPrefix20210422\Nette\Utils\Strings;
use RectorPrefix20210422\Symplify\ComposerJsonManipulator\ComposerJsonFactory;
use RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileSystem;
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
    public function __construct(\RectorPrefix20210422\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem, \RectorPrefix20210422\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory)
    {
        $this->smartFileSystem = $smartFileSystem;
        $this->composerJsonFactory = $composerJsonFactory;
    }
    /**
     * @return string|null
     */
    public function matchNamespaceForLocation(string $path)
    {
        $composerJsonFilePath = \getcwd() . '/composer.json';
        if (!$this->smartFileSystem->exists($composerJsonFilePath)) {
            return null;
        }
        $composerJson = $this->composerJsonFactory->createFromFilePath($composerJsonFilePath);
        $autoload = $composerJson->getAutoload();
        foreach ($autoload['psr-4'] ?? [] as $namespace => $directory) {
            if (!\is_array($directory)) {
                $directory = [$directory];
            }
            foreach ($directory as $singleDirectory) {
                if (!\RectorPrefix20210422\Nette\Utils\Strings::startsWith($path, $singleDirectory)) {
                    continue;
                }
                return \rtrim($namespace, '\\');
            }
        }
        return null;
    }
}
