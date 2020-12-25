<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class LoggableTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface
{
    public function getShortName() : string
    {
        return '_PhpScoperbf340cb0be9d\\@Gedmo\\Loggable';
    }
}
