<?php

declare (strict_types=1);
namespace Rector\Restoration\ClassMap;

use _PhpScoperf18a0c41e2d2\Nette\Loaders\RobotLoader;
use _PhpScoperf18a0c41e2d2\Nette\Utils\Arrays;
use Symplify\ComposerJsonManipulator\ComposerJsonFactory;
final class ExistingClassesProvider
{
    /**
     * @var string[]
     */
    private $existingClasses = [];
    /**
     * @var ComposerJsonFactory
     */
    private $composerJsonFactory;
    public function __construct(\Symplify\ComposerJsonManipulator\ComposerJsonFactory $composerJsonFactory)
    {
        $this->composerJsonFactory = $composerJsonFactory;
    }
    /**
     * @return string[]
     */
    public function provide() : array
    {
        if ($this->existingClasses === []) {
            $psr4Paths = $this->getPsr4PathFromComposerJson();
            /** @var string[] $existingClasses */
            $existingClasses = $this->findClassesInDirectories($psr4Paths);
            $existingClasses = \array_merge($existingClasses, \get_declared_classes());
            $this->existingClasses = $existingClasses;
        }
        return $this->existingClasses;
    }
    /**
     * @return string[]
     */
    private function getPsr4PathFromComposerJson() : array
    {
        $composerJsonFilePath = \getcwd() . '/composer.json';
        $composerJson = $this->composerJsonFactory->createFromFilePath($composerJsonFilePath);
        $psr4AndClassmapDirectories = $composerJson->getPsr4AndClassmapDirectories();
        return \_PhpScoperf18a0c41e2d2\Nette\Utils\Arrays::flatten($psr4AndClassmapDirectories);
    }
    /**
     * @param string[] $directories
     * @return string[]
     */
    private function findClassesInDirectories(array $directories) : array
    {
        $robotLoader = new \_PhpScoperf18a0c41e2d2\Nette\Loaders\RobotLoader();
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/rector_restore');
        foreach ($directories as $path) {
            $robotLoader->addDirectory(\getcwd() . '/' . $path);
        }
        $classNames = [];
        foreach (\array_keys($robotLoader->getIndexedClasses()) as $className) {
            if (!\is_string($className)) {
                continue;
            }
            $classNames[] = $className;
        }
        return $classNames;
    }
}
