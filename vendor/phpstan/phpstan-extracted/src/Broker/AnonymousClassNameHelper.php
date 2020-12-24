<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Broker;

use _PhpScoperb75b35f52b74\PHPStan\File\FileHelper;
use _PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper;
class AnonymousClassNameHelper
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var RelativePathHelper */
    private $relativePathHelper;
    public function __construct(\_PhpScoperb75b35f52b74\PHPStan\File\FileHelper $fileHelper, \_PhpScoperb75b35f52b74\PHPStan\File\RelativePathHelper $relativePathHelper)
    {
        $this->fileHelper = $fileHelper;
        $this->relativePathHelper = $relativePathHelper;
    }
    public function getAnonymousClassName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $classNode, string $filename) : string
    {
        if (isset($classNode->namespacedName)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        $filename = $this->relativePathHelper->getRelativePath($this->fileHelper->normalizePath($filename, '/'));
        return \sprintf('AnonymousClass%s', \md5(\sprintf('%s:%s', $filename, $classNode->getLine())));
    }
}
