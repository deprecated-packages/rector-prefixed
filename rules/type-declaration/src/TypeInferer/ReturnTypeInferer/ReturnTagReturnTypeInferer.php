<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ReturnTagReturnTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @param ClassMethod|Closure|Function_ $functionLike
     */
    public function inferFunctionLike(\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike $functionLike) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $phpDocInfo->getReturnType();
    }
    public function getPriority() : int
    {
        return 400;
    }
}
