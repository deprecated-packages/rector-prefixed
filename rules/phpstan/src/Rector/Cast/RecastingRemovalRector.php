<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\PHPStan\Rector\Cast;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Object_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\ArrayType;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPStan\Tests\Rector\Cast\RecastingRemovalRector\RecastingRemovalRectorTest
 */
final class RecastingRemovalRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const CAST_CLASS_TO_NODE_TYPE = [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\String_::class => \_PhpScoperb75b35f52b74\PHPStan\Type\StringType::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Bool_::class => \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Array_::class => \_PhpScoperb75b35f52b74\PHPStan\Type\ArrayType::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_::class => \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Object_::class => \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Double::class => \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType::class];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes recasting of the same type', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast::class];
    }
    /**
     * @param Cast $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $nodeClass = \get_class($node);
        if (!isset(self::CAST_CLASS_TO_NODE_TYPE[$nodeClass])) {
            return null;
        }
        $nodeType = $this->getStaticType($node->expr);
        if ($nodeType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType) {
            return null;
        }
        $sameNodeType = self::CAST_CLASS_TO_NODE_TYPE[$nodeClass];
        if (!\is_a($nodeType, $sameNodeType, \true)) {
            return null;
        }
        return $node->expr;
    }
}
