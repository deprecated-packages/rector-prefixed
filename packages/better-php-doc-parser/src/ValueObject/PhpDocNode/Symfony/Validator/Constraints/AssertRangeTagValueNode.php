<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints;

use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use _PhpScoper0a6b37af0871\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class AssertRangeTagValueNode extends \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScoper0a6b37af0871\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    public function getShortName() : string
    {
        return '_PhpScoper0a6b37af0871\\@Assert\\Range';
    }
    /**
     * @return mixed[]
     */
    public function getAttributableItems() : array
    {
        return $this->filterOutMissingItems($this->items);
    }
    public function getAttributeClassName() : string
    {
        return 'TBA';
    }
}
