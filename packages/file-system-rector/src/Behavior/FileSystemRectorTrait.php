<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\Behavior;

use _PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory;
trait FileSystemRectorTrait
{
    /**
     * @var MovedFileWithNodesFactory
     */
    protected $movedFileWithNodesFactory;
    /**
     * @required
     */
    public function autowireFileSystemRectorTrait(\_PhpScoper2a4e7ab1ecbc\Rector\FileSystemRector\ValueObjectFactory\MovedFileWithNodesFactory $movedFileWithNodesFactory) : void
    {
        $this->movedFileWithNodesFactory = $movedFileWithNodesFactory;
    }
}
