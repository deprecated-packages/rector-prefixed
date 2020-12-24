<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Testing\PHPUnit;

use _PhpScopere8e811afab72\Nette\Utils\Random;
use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\NodeFinder;
use _PhpScopere8e811afab72\Rector\Testing\Contract\RunnableInterface;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
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
        $this->runnableClassFinder = new \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder(new \_PhpScopere8e811afab72\PhpParser\NodeFinder());
        $this->classLikeNamesSuffixer = new \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer();
        $this->smartFileSystem = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function createRunnableClass(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $classContentFileInfo) : \_PhpScopere8e811afab72\Rector\Testing\Contract\RunnableInterface
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
    private function createTemporaryPathWithPrefix(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        // warning: if this hash is too short, the file can becom "identical"; took me 1 hour to find out
        $hash = \_PhpScopere8e811afab72\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -15);
        return \sprintf(\sys_get_temp_dir() . '/_rector_runnable_%s_%s', $hash, $smartFileInfo->getBasename('.inc'));
    }
    private function getTemporaryClassSuffix() : string
    {
        return \_PhpScopere8e811afab72\Nette\Utils\Random::generate(30);
    }
}
