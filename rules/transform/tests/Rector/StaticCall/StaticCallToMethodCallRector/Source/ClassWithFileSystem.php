<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\Source;

use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileSystem;
abstract class ClassWithFileSystem
{
    /**
     * @var SmartFileSystem
     */
    public $smartFileSystemProperty;
}
