<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\FileSystemRector\Behavior;

use _PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
