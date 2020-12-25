<?php

declare (strict_types=1);
namespace Rector\FileSystemRector\Behavior;

use Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
