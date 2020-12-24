<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPUnit\TestClassResolver;

use _PhpScoperb75b35f52b74\Nette\Loaders\RobotLoader;
use _PhpScoperb75b35f52b74\Rector\PHPUnit\Composer\ComposerAutoloadedDirectoryProvider;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\PHPUnit\Composer\ComposerAutoloadedDirectoryProvider $composerAutoloadedDirectoryProvider)
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
    private function createRobotLoadForDirectories() : \_PhpScoperb75b35f52b74\Nette\Loaders\RobotLoader
    {
        $robotLoader = new \_PhpScoperb75b35f52b74\Nette\Loaders\RobotLoader();
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
