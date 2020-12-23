<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\PhpDoc;

use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \_PhpScoper0a2ac50786fa\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \_PhpScoper0a2ac50786fa\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\_PhpScoper0a2ac50786fa\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \_PhpScoper0a2ac50786fa\PHPStan\Type\ArrayType
    {
        $arrayBuilder = \_PhpScoper0a2ac50786fa\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
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
