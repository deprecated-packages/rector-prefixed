<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;

use PhpParser\Node\Expr\Closure;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface;
use Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class ReturnTagReturnTypeInferer extends \Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \Rector\TypeDeclaration\Contract\TypeInferer\ReturnTypeInfererInterface
{
    /**
     * @param ClassMethod|Closure|Function_ $functionLike
     */
    public function inferFunctionLike(\PhpParser\Node\FunctionLike $functionLike) : \PHPStan\Type\Type
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \PHPStan\Type\MixedType();
        }
        return $phpDocInfo->getReturnType();
    }
    public function getPriority() : int
    {
        return 400;
    }
}
