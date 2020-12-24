<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\DocBlock;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode;
use _PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode;
final class ThrowsFactory
{
    public function crateDocTagNodeFromClass(string $throwableClass) : \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode
    {
        $throwsTagValueNode = new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\PhpDoc\ThrowsTagValueNode(new \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\Type\IdentifierTypeNode($throwableClass), '');
        return new \_PhpScopere8e811afab72\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\AttributeAwarePhpDocTagNode('@throws', $throwsTagValueNode);
    }
}
