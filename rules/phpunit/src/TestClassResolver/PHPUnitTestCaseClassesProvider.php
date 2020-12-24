<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\TestClassResolver;

use _PhpScoper0a6b37af0871\Nette\Loaders\RobotLoader;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\Composer\ComposerAutoloadedDirectoryProvider;
final class PHPUnitTestCaseClassesProvider
{
    /**
     * @var string[]
     */
    private $phpUnitTestCaseClasses = [];
    /**
     * @var ComposerAutoloadedDirectoryProvider
     */
    private $composerAutoloadedDirectoryProvider;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Composer\ComposerAutoloadedDirectoryProvider $composerAutoloadedDirectoryProvider)
    {
        $this->composerAutoloadedDirectoryProvider = $composerAutoloadedDirectoryProvider;
    }
    /**
     * @return string[]
     */
    public function provide() : array
    {
        if ($this->phpUnitTestCaseClasses !== []) {
            return $this->phpUnitTestCaseClasses;
        }
        $robotLoader = $this->createRobotLoadForDirectories();
        $robotLoader->rebuild();
        foreach (\array_keys($robotLoader->getIndexedClasses()) as $className) {
            $this->phpUnitTestCaseClasses[] = (string) $className;
        }
        return $this->phpUnitTestCaseClasses;
    }
    private function createRobotLoadForDirectories() : \_PhpScoper0a6b37af0871\Nette\Loaders\RobotLoader
    {
        $robotLoader = new \_PhpScoper0a6b37af0871\Nette\Loaders\RobotLoader();
        $robotLoader->setTempDirectory(\sys_get_temp_dir() . '/tests_add_see_rector_tests');
        $directories = $this->composerAutoloadedDirectoryProvider->provide();
        $robotLoader->addDirectory(...$directories);
        $robotLoader->acceptFiles = ['*Test.php'];
        $robotLoader->ignoreDirs[] = '*Expected*';
        $robotLoader->ignoreDirs[] = '*Fixture*';
        $robotLoader->ignoreDirs[] = 'templates';
        return $robotLoader;
    }
}
