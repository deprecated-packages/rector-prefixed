<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
abstract class AbstractDoctrineTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\Doctrine\DoctrineTagNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface
{
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return $this->filterOutMissingItems($this->items);
    }
}
