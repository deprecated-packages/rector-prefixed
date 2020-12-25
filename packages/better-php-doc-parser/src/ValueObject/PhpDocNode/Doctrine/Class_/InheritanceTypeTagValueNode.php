<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Class_;

use Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode;
final class InheritanceTypeTagValueNode extends \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\AbstractDoctrineTagValueNode implements \Rector\BetterPhpDocParser\Contract\PhpDocNode\SilentKeyNodeInterface
{
    public function getShortName() : string
    {
        return '_PhpScoper50d83356d739\\@ORM\\InheritanceType';
    }
    public function getSilentKey() : string
    {
        return 'value';
    }
}
