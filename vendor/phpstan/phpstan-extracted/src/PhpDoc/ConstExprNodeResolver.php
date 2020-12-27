<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use PHPStan\Type\ConstantTypeHelper;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \PHPStan\Type\Type
    {
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \PHPStan\Type\ArrayType
    {
        $arrayBuilder = \PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
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
