<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\FileSystemRector\Behavior;

use _PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\_PhpScoper0a2ac50786fa\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
