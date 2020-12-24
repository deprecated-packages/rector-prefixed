<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPStan\Rector\Cast;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Double;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Int_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Object_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\BooleanType;
use _PhpScopere8e811afab72\PHPStan\Type\FloatType;
use _PhpScopere8e811afab72\PHPStan\Type\IntegerType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\StringType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPStan\Tests\Rector\Cast\RecastingRemovalRector\RecastingRemovalRectorTest
 */
final class RecastingRemovalRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const CAST_CLASS_TO_NODE_TYPE = [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\String_::class => \_PhpScopere8e811afab72\PHPStan\Type\StringType::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Bool_::class => \_PhpScopere8e811afab72\PHPStan\Type\BooleanType::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Array_::class => \_PhpScopere8e811afab72\PHPStan\Type\ArrayType::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Int_::class => \_PhpScopere8e811afab72\PHPStan\Type\IntegerType::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Object_::class => \_PhpScopere8e811afab72\PHPStan\Type\ObjectType::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast\Double::class => \_PhpScopere8e811afab72\PHPStan\Type\FloatType::class];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes recasting of the same type', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$string = '';
$string = (string) $string;

$array = [];
$array = (array) $array;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$string = '';
$string = $string;

$array = [];
$array = $array;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Cast::class];
    }
    /**
     * @param Cast $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $nodeClass = \get_class($node);
        if (!isset(self::CAST_CLASS_TO_NODE_TYPE[$nodeClass])) {
            return null;
        }
        $nodeType = $this->getStaticType($node->expr);
        if ($nodeType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return null;
        }
        $sameNodeType = self::CAST_CLASS_TO_NODE_TYPE[$nodeClass];
        if (!\is_a($nodeType, $sameNodeType, \true)) {
            return null;
        }
        return $node->expr;
    }
}
