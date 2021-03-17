<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Contract\Doctrine;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface DoctrineRelationTagValueNodeInterface extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getTargetEntity() : ?string;
    public function getFullyQualifiedTargetEntity() : ?string;
    /**
     * @param string $targetEntity
     */
    public function changeTargetEntity($targetEntity) : void;
}
