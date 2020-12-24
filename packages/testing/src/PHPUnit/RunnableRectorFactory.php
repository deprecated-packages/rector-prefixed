<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit;

use _PhpScoper0a6b37af0871\Nette\Utils\Random;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\NodeFinder;
use _PhpScoper0a6b37af0871\Rector\Testing\Contract\RunnableInterface;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
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
        $this->runnableClassFinder = new \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder(new \_PhpScoper0a6b37af0871\PhpParser\NodeFinder());
        $this->classLikeNamesSuffixer = new \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer();
        $this->smartFileSystem = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function createRunnableClass(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $classContentFileInfo) : \_PhpScoper0a6b37af0871\Rector\Testing\Contract\RunnableInterface
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
    private function createTemporaryPathWithPrefix(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        // warning: if this hash is too short, the file can becom "identical"; took me 1 hour to find out
        $hash = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -15);
        return \sprintf(\sys_get_temp_dir() . '/_rector_runnable_%s_%s', $hash, $smartFileInfo->getBasename('.inc'));
    }
    private function getTemporaryClassSuffix() : string
    {
        return \_PhpScoper0a6b37af0871\Nette\Utils\Random::generate(30);
    }
}
