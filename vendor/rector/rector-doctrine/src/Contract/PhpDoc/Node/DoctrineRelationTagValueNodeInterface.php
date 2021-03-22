<?php

declare (strict_types=1);
namespace Rector\Doctrine\Contract\PhpDoc\Node;

use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface DoctrineRelationTagValueNodeInterface extends \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getTargetEntity() : ?string;
    public function getFullyQualifiedTargetEntity() : ?string;
    public function changeTargetEntity(string $targetEntity) : void;
}
