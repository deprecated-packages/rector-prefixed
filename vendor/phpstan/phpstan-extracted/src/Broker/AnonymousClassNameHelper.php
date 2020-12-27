<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Broker;

use RectorPrefix20201227\PHPStan\File\FileHelper;
use RectorPrefix20201227\PHPStan\File\RelativePathHelper;
class AnonymousClassNameHelper
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\RectorPrefix20201227\PHPStan\File\FileHelper $fileHelper, \RectorPrefix20201227\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->relativePathHelper = $relativePathHelper;
    }
    public function getAnonymousClassName(\PhpParser\Node\Stmt\Class_ $classNode, string $filename) : string
    {
        if (isset($classNode->namespacedName)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        $filename = $this->relativePathHelper->getRelativePath($this->fileHelper->normalizePath($filename, '/'));
        return \sprintf('AnonymousClass%s', \md5(\sprintf('%s:%s', $filename, $classNode->getLine())));
    }
}
