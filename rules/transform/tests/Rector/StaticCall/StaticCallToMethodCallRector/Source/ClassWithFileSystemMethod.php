<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\Source;

use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem;
abstract class ClassWithFileSystemMethod
{
    public function getSmartFileSystem() : \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileSystem();
    }
}
