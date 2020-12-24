<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \_PhpScopere8e811afab72\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \_PhpScopere8e811afab72\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\_PhpScopere8e811afab72\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \_PhpScopere8e811afab72\PHPStan\Type\ArrayType
    {
        $arrayBuilder = \_PhpScopere8e811afab72\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
        foreach ($node->items as $item) {
            if ($item->key === null) {
                $key = null;
            } else {
                $key = $this->resolve($item->key);
            }
            $arrayBuilder->setOffsetValueType($key, $this->resolve($item->value));
        }
        return $arrayBuilder->getArray();
    }
}
