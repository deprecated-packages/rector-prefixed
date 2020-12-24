<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Broker;

use _PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\RelativePathHelper;
class AnonymousClassNameHelper
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper $fileHelper, \_PhpScoper2a4e7ab1ecbc\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->relativePathHelper = $relativePathHelper;
    }
    public function getAnonymousClassName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $classNode, string $filename) : string
    {
        if (isset($classNode->namespacedName)) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
        }
        $filename = $this->relativePathHelper->getRelativePath($this->fileHelper->normalizePath($filename, '/'));
        return \sprintf('AnonymousClass%s', \md5(\sprintf('%s:%s', $filename, $classNode->getLine())));
    }
}
