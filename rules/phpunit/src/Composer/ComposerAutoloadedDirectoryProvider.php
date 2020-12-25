<?php

declare (strict_types=1);
namespace Rector\PHPUnit\Composer;

use _PhpScoperf18a0c41e2d2\Nette\Utils\Arrays;
use _PhpScoperf18a0c41e2d2\Nette\Utils\Json;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use Symplify\SmartFileSystem\SmartFileSystem;
final class ComposerAutoloadedDirectoryProvider
{
    /**
     * @var string[]
     */
    private const AUTOLOAD_SECTIONS = ['autolaod', 'autoload-dev'];
    /**
     * @var string
     */
    private $composerFilePath;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct(\Symplify\SmartFileSystem\SmartFileSystem $smartFileSystem)
    {
        $this->composerFilePath = \getcwd() . '/composer.json';
        $this->smartFileSystem = $smartFileSystem;
    }
    /**
     * @return string[]|mixed[]
     */
    public function provide() : array
    {
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return [\getcwd() . '/src', \getcwd() . '/tests', \getcwd() . '/packages', \getcwd() . '/rules'];
        }
        $composerJson = $this->loadComposerJsonArray();
        $autoloadDirectories = [];
        foreach (self::AUTOLOAD_SECTIONS as $autoloadSection) {
            if (!isset($composerJson[$autoloadSection])) {
                continue;
            }
            $sectionDirectories = $this->collectDirectoriesFromAutoload($composerJson[$autoloadSection]);
            $autoloadDirectories[] = $sectionDirectories;
        }
        return \_PhpScoperf18a0c41e2d2\Nette\Utils\Arrays::flatten($autoloadDirectories);
    }
    /**
     * @return mixed[]
     */
    private function loadComposerJsonArray() : array
    {
        if (!\file_exists($this->composerFilePath)) {
            return [];
        }
        $composerFileContent = $this->smartFileSystem->readFile($this->composerFilePath);
        return \_PhpScoperf18a0c41e2d2\Nette\Utils\Json::decode($composerFileContent, \_PhpScoperf18a0c41e2d2\Nette\Utils\Json::FORCE_ARRAY);
    }
    /**
     * @param string[] $composerJsonAutoload
     * @return string[]
     */
    private function collectDirectoriesFromAutoload(array $composerJsonAutoload) : array
    {
        $autoloadDirectories = [];
        if (isset($composerJsonAutoload['psr-4'])) {
            /** @var string[] $psr4 */
            $psr4 = $composerJsonAutoload['psr-4'];
            $autoloadDirectories = \array_merge($autoloadDirectories, $psr4);
        }
        if (isset($composerJsonAutoload['classmap'])) {
            /** @var string[] $classmap */
            $classmap = $composerJsonAutoload['classmap'];
            foreach ($classmap as $fileOrDirectory) {
                $fileOrDirectory = \getcwd() . '/' . $fileOrDirectory;
                // skip file, we look only for directories
                if (\file_exists($fileOrDirectory)) {
                    continue;
                }
                $autoloadDirectories[] = $fileOrDirectory;
            }
        }
        return \array_values($autoloadDirectories);
    }
}
