<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScopere8e811afab72\PhpParser\Node\FunctionLike;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer;
final class FunctionLikeDocParamTypeInferer extends \_PhpScopere8e811afab72\Rector\TypeDeclaration\TypeInferer\AbstractTypeInferer implements \_PhpScopere8e811afab72\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function inferParam(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $functionLike = $this->resolveScopeNode($param);
        if ($functionLike === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $functionLike->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        $paramTypesByName = $phpDocInfo->getParamTypesByName();
        if ($paramTypesByName === []) {
            return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
        }
        return $this->matchParamNodeFromDoc($paramTypesByName, $param);
    }
    private function resolveScopeNode(\_PhpScopere8e811afab72\PhpParser\Node\Param $param) : ?\_PhpScopere8e811afab72\PhpParser\Node\FunctionLike
    {
        return $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE) ?? $param->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FUNCTION_NODE);
    }
    /**
     * @param Type[] $paramWithTypes
     */
    private function matchParamNodeFromDoc(array $paramWithTypes, \_PhpScopere8e811afab72\PhpParser\Node\Param $param) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        $paramNodeName = '$' . $this->nodeNameResolver->getName($param->var);
        return $paramWithTypes[$paramNodeName] ?? new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
}
