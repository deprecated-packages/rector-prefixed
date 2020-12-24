<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SensioRouteTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function getShortName() : string
    {
        return '@Route';
    }
    public function getSilentKey() : string
    {
        return 'path';
    }
    public function removeService() : void
    {
        unset($this->items['service']);
    }
}
