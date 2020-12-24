<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Sensio;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class SensioTemplateTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function getTemplate() : ?string
    {
        return $this->items['template'];
    }
    /**
     * @return string[]
     */
    public function getVars() : array
    {
        return $this->items['vars'] ?? [];
    }
    public function getShortName() : string
    {
        return '@Template';
    }
    public function getSilentKey() : string
    {
        return 'template';
    }
}
