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
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory;
final class PropertyRanker
{
    /**
     * @var string[]
     */
    private const TYPE_TO_RANK = [\PHPStan\Type\StringType::class => 5, \PHPStan\Type\IntegerType::class => 5, \PHPStan\Type\BooleanType::class => 5, \PHPStan\Type\FloatType::class => 5, \PHPStan\Type\ArrayType::class => 10, \PHPStan\Type\IterableType::class => 10, \PHPStan\Type\TypeWithClassName::class => 15, \PHPStan\Type\IntersectionType::class => 20, \PHPStan\Type\UnionType::class => 25, \PHPStan\Type\MixedType::class => 30, \PHPStan\Type\CallableType::class => 35];
    /**
     * @var PhpDocInfoFactory
     */
    private $phpDocInfoFactory;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfoFactory $phpDocInfoFactory)
    {
        $this->phpDocInfoFactory = $phpDocInfoFactory;
    }
    public function rank(\PhpParser\Node\Stmt\Property $property) : int
    {
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($property);
        $varType = $phpDocInfo->getVarType();
        foreach (self::TYPE_TO_RANK as $type => $rank) {
            if (\is_a($varType, $type, \true)) {
                return $rank;
            }
        }
        // fallback
        return 1;
    }
}
