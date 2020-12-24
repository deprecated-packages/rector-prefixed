<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Random;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\Contract\RunnableInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem;
final class RunnableRectorFactory
{
    /**
     * @var RunnableClassFinder
     */
    private $runnableClassFinder;
    /**
     * @var ClassLikeNamesSuffixer
     */
    private $classLikeNamesSuffixer;
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;
    public function __construct()
    {
        $this->runnableClassFinder = new \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder(new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeFinder());
        $this->classLikeNamesSuffixer = new \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer();
        $this->smartFileSystem = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function createRunnableClass(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $classContentFileInfo) : \_PhpScoper2a4e7ab1ecbc\Rector\Testing\Contract\RunnableInterface
    {
        $temporaryPath = $this->createTemporaryPathWithPrefix($classContentFileInfo);
        $contents = $classContentFileInfo->getContents();
        $temporaryClassSuffix = $this->getTemporaryClassSuffix();
        $suffixedFileContent = $this->classLikeNamesSuffixer->suffixContent($contents, $temporaryClassSuffix);
        $this->smartFileSystem->dumpFile($temporaryPath, $suffixedFileContent);
        include_once $temporaryPath;
        $runnableFullyQualifiedClassName = $this->runnableClassFinder->find($suffixedFileContent);
        return new $runnableFullyQualifiedClassName();
    }
    private function createTemporaryPathWithPrefix(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        // warning: if this hash is too short, the file can becom "identical"; took me 1 hour to find out
        $hash = \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -15);
        return \sprintf(\sys_get_temp_dir() . '/_rector_runnable_%s_%s', $hash, $smartFileInfo->getBasename('.inc'));
    }
    private function getTemporaryClassSuffix() : string
    {
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Random::generate(30);
    }
}
