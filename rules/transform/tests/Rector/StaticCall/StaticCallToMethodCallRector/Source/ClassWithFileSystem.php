<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\Source;

use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileSystem;
abstract class ClassWithFileSystem
{
    /**
     * @var SmartFileSystem
     */
    public $smartFileSystemProperty;
}
