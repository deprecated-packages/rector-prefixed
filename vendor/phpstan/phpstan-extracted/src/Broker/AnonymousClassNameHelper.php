<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Broker;

use _PhpScoper0a2ac50786fa\PHPStan\File\FileHelper;
use _PhpScoper0a2ac50786fa\PHPStan\File\RelativePathHelper;
class AnonymousClassNameHelper
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\File\FileHelper $fileHelper, \_PhpScoper0a2ac50786fa\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->relativePathHelper = $relativePathHelper;
    }
    public function getAnonymousClassName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $classNode, string $filename) : string
    {
        if (isset($classNode->namespacedName)) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
        }
        $filename = $this->relativePathHelper->getRelativePath($this->fileHelper->normalizePath($filename, '/'));
        return \sprintf('AnonymousClass%s', \md5(\sprintf('%s:%s', $filename, $classNode->getLine())));
    }
}
