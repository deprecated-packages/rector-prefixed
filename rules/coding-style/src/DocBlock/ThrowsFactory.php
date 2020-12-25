<?php

declare (strict_types=1);
namespace Rector\CodingStyle\DocBlock;

use PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
final class ThrowsFactory
{
    public function crateDocTagNodeFromClass(string $throwableClass) : \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode
    {
        $throwsTagValueNode = new \PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode(new \PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($throwableClass), '');
        return new \Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@throws', $throwsTagValueNode);
    }
}
