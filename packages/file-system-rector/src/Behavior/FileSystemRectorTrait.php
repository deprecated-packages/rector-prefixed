<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\FileSystemRector\Behavior;

use _PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\_PhpScoper0a6b37af0871\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
