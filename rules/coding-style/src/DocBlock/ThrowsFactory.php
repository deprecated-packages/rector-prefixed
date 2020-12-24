<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\DocBlock;

use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
final class ThrowsFactory
{
    public function crateDocTagNodeFromClass(string $throwableClass) : \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode
    {
        $throwsTagValueNode = new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode(new \_PhpScoper0a6b37af0871\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($throwableClass), '');
        return new \_PhpScoper0a6b37af0871\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@throws', $throwsTagValueNode);
    }
}
