<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Gedmo;

use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode;
final class BlameableTagValueNode extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\AbstractTagValueNode implements \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Contract\PhpDocNode\ShortNameAwareTagInterface
{
    public function getShortName() : string
    {
        return '_PhpScoperb75b35f52b74\\@Gedmo\\Blameable';
    }
}
