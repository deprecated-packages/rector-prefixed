<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Contract\Doctrine;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface DoctrineRelationTagValueNodeInterface extends \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getTargetEntity() : ?string;
    public function getFullyQualifiedTargetEntity() : ?string;
    public function changeTargetEntity(string $targetEntity) : void;
}
