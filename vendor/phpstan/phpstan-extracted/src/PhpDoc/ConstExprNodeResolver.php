<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\PhpDoc;

use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder;
use _PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
class ConstExprNodeResolver
{
    public function resolve(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNode $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\Type
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode) {
            return $this->resolveArrayNode($node);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFalseNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\false);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprTrueNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(\true);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprFloatNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((float) $node->value);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprIntegerNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue((int) $node->value);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprNullNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue(null);
        }
        if ($node instanceof \_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprStringNode) {
            return \_PhpScoperb75b35f52b74\PHPStan\Type\ConstantTypeHelper::getTypeFromValue($node->value);
        }
        return new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
    }
    private function resolveArrayNode(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\ConstExpr\ConstExprArrayNode $node) : \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType
    {
        $arrayBuilder = \_PhpScoperb75b35f52b74\PHPStan\Type\Constant\ConstantArrayTypeBuilder::createEmpty();
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
