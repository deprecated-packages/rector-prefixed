<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Contract\Doctrine;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode;
interface DoctrineRelationTagValueNodeInterface extends \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagValueNode
{
    public function getTargetEntity() : ?string;
    public function getFullyQualifiedTargetEntity() : ?string;
    public function changeTargetEntity(string $targetEntity) : void;
}
