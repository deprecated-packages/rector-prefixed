<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\Validator\Constraints;

use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
/**
 * @see \Rector\BetterPhpDocParser\PhpDocNodeFactory\Symfony\Validator\Constraints\AssertTypePhpDocNodeFactory
 *
 * @see \Rector\BetterPhpDocParser\Tests\PhpDocParser\TagValueNodeReprint\AssertTypeTagValueNodeTest
 */
final class AssertTypeTagValueNode extends \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface, \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function getShortName() : string
    {
        return '_PhpScopere8e811afab72\\@Assert\\Type';
    }
    public function getSilentKey() : string
    {
        return 'type';
    }
}
