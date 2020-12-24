<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Order;

use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\CallableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IterableType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName;
use _PhpScoperb75b35f52b74\PHPStan\Type\UnionType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    public function rank(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType || $varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType || $varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType || $varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType) {
            return 5;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType || $varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IterableType) {
            return 10;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\TypeWithClassName) {
            return 15;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntersectionType) {
            return 20;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\UnionType) {
            return 25;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return 30;
        }
        if ($varType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\CallableType) {
            return 35;
        }
        throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
