<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit;

use _PhpScoperb75b35f52b74\Nette\Utils\Random;
use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\NodeFinder;
use _PhpScoperb75b35f52b74\Rector\Testing\Contract\RunnableInterface;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
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
        $this->runnableClassFinder = new \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\RunnableClassFinder(new \_PhpScoperb75b35f52b74\PhpParser\NodeFinder());
        $this->classLikeNamesSuffixer = new \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\Runnable\ClassLikeNamesSuffixer();
        $this->smartFileSystem = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem();
    }
    public function createRunnableClass(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $classContentFileInfo) : \_PhpScoperb75b35f52b74\Rector\Testing\Contract\RunnableInterface
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
    private function createTemporaryPathWithPrefix(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        // warning: if this hash is too short, the file can becom "identical"; took me 1 hour to find out
        $hash = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring(\md5($smartFileInfo->getRealPath()), -15);
        return \sprintf(\sys_get_temp_dir() . '/_rector_runnable_%s_%s', $hash, $smartFileInfo->getBasename('.inc'));
    }
    private function getTemporaryClassSuffix() : string
    {
        return \_PhpScoperb75b35f52b74\Nette\Utils\Random::generate(30);
    }
}
