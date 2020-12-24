<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\Source;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
abstract class ClassWithFileSystemMethod
{
    public function getSmartFileSystem() : \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem
    {
        return new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem();
    }
}
