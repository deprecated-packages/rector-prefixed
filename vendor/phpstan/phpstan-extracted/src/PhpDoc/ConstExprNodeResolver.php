<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDoc;

use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType
    {
        $arrayBuilder = \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
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
