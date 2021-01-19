<?php

declare (strict_types=1);
namespace Rector\Order;

use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ArrayType;
use PHPStan\Type\BooleanType;
use PHPStan\Type\CallableType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\IntersectionType;
use PHPStan\Type\IterableType;
use PHPStan\Type\MixedType;
use PHPStan\Type\StringType;
use PHPStan\Type\TypeWithClassName;
use PHPStan\Type\UnionType;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Exception\NotImplementedException;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class PropertyRanker
{
    /**
     * @var string[]
     */
    private const TYPE_TO_RANK = [\PHPStan\Type\StringType::class => 5, \PHPStan\Type\IntegerType::class => 5, \PHPStan\Type\BooleanType::class => 5, \PHPStan\Type\FloatType::class => 5, \PHPStan\Type\ArrayType::class => 10, \PHPStan\Type\IterableType::class => 10, \PHPStan\Type\TypeWithClassName::class => 15, \PHPStan\Type\IntersectionType::class => 20, \PHPStan\Type\UnionType::class => 25, \PHPStan\Type\MixedType::class => 30, \PHPStan\Type\CallableType::class => 35];
    public function rank(\PhpParser\Node\Stmt\Property $property) : int
    {
        $phpDocInfo = $property->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return 1;
        }
        $varType = $phpDocInfo->getVarType();
        foreach (self::TYPE_TO_RANK as $type => $rank) {
            if (\is_a($varType, $type, \true)) {
                return $rank;
            }
        }
        throw new \Rector\Core\Exception\NotImplementedException(\get_class($varType));
    }
}
