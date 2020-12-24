<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Order;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\CallableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedException;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
final class PropertyRanker
{
    /**
     * @var string[]
     */
    private const TYPE_TO_RANK = [\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType::class => 5, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType::class => 5, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType::class => 5, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType::class => 5, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType::class => 10, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IterableType::class => 10, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\TypeWithClassName::class => 15, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntersectionType::class => 20, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\UnionType::class => 25, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType::class => 30, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\CallableType::class => 35];
    public function rank(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property $property) : int
    {
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $property->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        foreach (self::TYPE_TO_RANK as $type => $rank) {
            if (\is_a($varType, $type, \true)) {
                return $rank;
            }
        }
        throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
