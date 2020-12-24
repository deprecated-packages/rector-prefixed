<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\Source;

use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem;
abstract class ClassWithFileSystemMethod
{
    public function getSmartFileSystem() : \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileSystem();
    }
}
