<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SlugTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    /**
     * @return mixed[]
     */
    public function getFields() : array
    {
        return $this->items['fields'];
    }
    public function getShortName() : string
    {
        return '_PhpScopere8e811afab72\\@Gedmo\\Slug';
    }
    public function getSilentKey() : string
    {
        return 'fields';
    }
}
