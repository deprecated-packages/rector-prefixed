<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\TypeInferer\ParamTypeInferer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface;
final class PHPUnitDataProviderParamTypeInferer implements \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Contract\TypeInferer\ParamTypeInfererInterface
{
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var TypeFactory
     */
    private $typeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\PHPStan\Type\TypeFactory $typeFactory)
    {
        $this->betterNodeFinder = $betterNodeFinder;
        $this->typeFactory = $typeFactory;
    }
    /**
     * Prevents circular reference
     * @required
     */
    public function autowirePHPUnitDataProviderParamTypeInferer(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver) : void
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function inferParam(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $dataProviderClassMethod = $this->resolveDataProviderClassMethod($param);
        if ($dataProviderClassMethod === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        $parameterPosition = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARAMETER_POSITION);
        if ($parameterPosition === null) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        /** @var Return_[] $returns */
        $returns = $this->betterNodeFinder->findInstanceOf((array) $dataProviderClassMethod->stmts, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_::class);
        return $this->resolveReturnStaticArrayTypeByParameterPosition($returns, $parameterPosition);
    }
    private function resolveDataProviderClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $phpDocInfo = $this->getFunctionLikePhpDocInfo($param);
        if ($phpDocInfo === null) {
            return null;
        }
        /** @var DataProviderTagValueNode|null $attributeAwareDataProviderTagValueNode */
        $attributeAwareDataProviderTagValueNode = $phpDocInfo->getByType(\_PhpScoperb75b35f52b74\Rector\AttributeAwarePhpDoc\Ast\PhpDoc\DataProviderTagValueNode::class);
        if ($attributeAwareDataProviderTagValueNode === null) {
            return null;
        }
        $classLike = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        return $classLike->getMethod($attributeAwareDataProviderTagValueNode->getMethodName());
    }
    /**
     * @param Return_[] $returns
     */
    private function resolveReturnStaticArrayTypeByParameterPosition(array $returns, int $parameterPosition) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        $paramOnPositionTypes = [];
        foreach ($returns as $classMethodReturn) {
            if (!$classMethodReturn->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
                continue;
            }
            $arrayTypes = $this->nodeTypeResolver->resolve($classMethodReturn->expr);
            // impossible to resolve
            if (!$arrayTypes instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayType) {
                return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
            }
            // nest to 1 item
            foreach ($arrayTypes->getValueTypes() as $position => $valueType) {
                if ($position !== $parameterPosition) {
                    continue;
                }
                $paramOnPositionTypes[] = $valueType;
            }
        }
        if ($paramOnPositionTypes === []) {
            return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
        }
        return $this->typeFactory->createMixedPassedOrUnionType($paramOnPositionTypes);
    }
    private function getFunctionLikePhpDocInfo(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param) : ?\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo
    {
        $parent = $param->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike) {
            return null;
        }
        return $parent->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
    }
}
