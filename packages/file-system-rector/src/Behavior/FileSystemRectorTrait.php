<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\FileSystemRector\Behavior;

use _PhpScopere8e811afab72\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\_PhpScopere8e811afab72\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
