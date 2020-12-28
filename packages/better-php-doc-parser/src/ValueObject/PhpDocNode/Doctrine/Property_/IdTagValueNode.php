<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_;

use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
use Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface;
final class IdTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \Rector\PhpAttribute\Contract\PhpAttributableTagNodeInterface
{
    public function getShortName() : string
    {
        return '@ORM\\Id';
    }
    public function getAttributeClassName() : string
    {
        return 'TBA';
    }
}
