<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
use _PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class AssertRangeTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\TypeAwareTagValueNodeInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    public function getShortName() : string
    {
        return '_PhpScopere8e811afab72\\@Assert\\Range';
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
