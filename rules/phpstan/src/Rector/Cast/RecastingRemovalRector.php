<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PHPStan\Rector\Cast;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Double;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Object_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\String_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPStan\Tests\Rector\Cast\RecastingRemovalRector\RecastingRemovalRectorTest
 */
final class RecastingRemovalRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const CAST_CLASS_TO_NODE_TYPE = [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\String_::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Bool_::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Array_::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ArrayType::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Int_::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Object_::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast\Double::class => \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType::class];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes recasting of the same type', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Cast::class];
    }
    /**
     * @param Cast $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $nodeClass = \get_class($node);
        if (!isset(self::CAST_CLASS_TO_NODE_TYPE[$nodeClass])) {
            return null;
        }
        $nodeType = $this->getStaticType($node->expr);
        if ($nodeType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType) {
            return null;
        }
        $sameNodeType = self::CAST_CLASS_TO_NODE_TYPE[$nodeClass];
        if (!\is_a($nodeType, $sameNodeType, \true)) {
            return null;
        }
        return $node->expr;
    }
}
