<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\DocBlock;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
final class ThrowsFactory
{
    public function crateDocTagNodeFromClass(string $throwableClass) : \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode
    {
        $throwsTagValueNode = new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode(new \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($throwableClass), '');
        return new \_PhpScoper0a2ac50786fa\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@throws', $throwsTagValueNode);
    }
}
