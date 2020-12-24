<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\Contract\Doctrine;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface DoctrineRelationTagValueNodeInterface extends \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getTargetEntity() : ?string;
    public function getFullyQualifiedTargetEntity() : ?string;
    public function changeTargetEntity(string $targetEntity) : void;
}
