<?php

declare (strict_types=1);
namespace Rector\Php74\Rector\FuncCall;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ArrayType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\Type;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/spread_operator_for_array
 * @see https://twitter.com/nikita_ppv/status/1126470222838366209
 * @see \Rector\Php74\Tests\Rector\FuncCall\ArraySpreadInsteadOfArrayMergeRector\ArraySpreadInsteadOfArrayMergeRectorTest
 */
final class ArraySpreadInsteadOfArrayMergeRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ArrayTypeAnalyzer
     */
    private $arrayTypeAnalyzer;
    public function __construct(\Rector\NodeTypeResolver\TypeAnalyzer\ArrayTypeAnalyzer $arrayTypeAnalyzer)
    {
        $this->arrayTypeAnalyzer = $arrayTypeAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array_merge() to spread operator, except values with possible string key values', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($iter1, $iter2)
    {
        $values = array_merge(iterator_to_array($iter1), iterator_to_array($iter2));

        // Or to generalize to all iterables
        $anotherValues = array_merge(
            is_array($iter1) ? $iter1 : iterator_to_array($iter1),
            is_array($iter2) ? $iter2 : iterator_to_array($iter2)
        );
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($iter1, $iter2)
    {
        $values = [...$iter1, ...$iter2];

        // Or to generalize to all iterables
        $anotherValues = [...$iter1, ...$iter2];
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isAtLeastPhpVersion(\Rector\Core\ValueObject\PhpVersionFeature::ARRAY_SPREAD)) {
            return null;
        }
        if ($this->isName($node, 'array_merge')) {
            return $this->refactorArray($node);
        }
        return null;
    }
    private function refactorArray(\PhpParser\Node\Expr\FuncCall $funcCall) : ?\PhpParser\Node\Expr\Array_
    {
        $array = new \PhpParser\Node\Expr\Array_();
        foreach ($funcCall->args as $arg) {
            // cannot handle unpacked arguments
            if ($arg->unpack) {
                return null;
            }
            $value = $arg->value;
            if ($this->shouldSkipArrayForInvalidTypeOrKeys($value)) {
                return null;
            }
            $value = $this->resolveValue($value);
            $array->items[] = $this->createUnpackedArrayItem($value);
        }
        return $array;
    }
    private function shouldSkipArrayForInvalidTypeOrKeys(\PhpParser\Node\Expr $expr) : bool
    {
        // we have no idea what it is → cannot change it
        if (!$this->arrayTypeAnalyzer->isArrayType($expr)) {
            return \true;
        }
        $arrayStaticType = $this->getStaticType($expr);
        if ($this->isConstantArrayTypeWithStringKeyType($arrayStaticType)) {
            return \true;
        }
        if (!$arrayStaticType instanceof \PHPStan\Type\ArrayType) {
            return \true;
        }
        // integer key type is required, @see https://twitter.com/nikita_ppv/status/1126470222838366209
        return !$arrayStaticType->getKeyType() instanceof \PHPStan\Type\IntegerType;
    }
    private function resolveValue(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr
    {
        if ($this->isIteratorToArrayFuncCall($expr)) {
            /** @var FuncCall $expr */
            $expr = $expr->args[0]->value;
        }
        if (!$expr instanceof \PhpParser\Node\Expr\Ternary) {
            return $expr;
        }
        if (!$expr->cond instanceof \PhpParser\Node\Expr\FuncCall) {
            return $expr;
        }
        if (!$this->isName($expr->cond, 'is_array')) {
            return $expr;
        }
        if ($expr->if instanceof \PhpParser\Node\Expr\Variable && $this->isIteratorToArrayFuncCall($expr->else)) {
            return $expr->if;
        }
        return $expr;
    }
    private function createUnpackedArrayItem(\PhpParser\Node\Expr $expr) : \PhpParser\Node\Expr\ArrayItem
    {
        return new \PhpParser\Node\Expr\ArrayItem($expr, null, \false, [], \true);
    }
    private function isConstantArrayTypeWithStringKeyType(\PHPStan\Type\Type $type) : bool
    {
        if (!$type instanceof \PHPStan\Type\Constant\ConstantArrayType) {
            return \false;
        }
        foreach ($type->getKeyTypes() as $keyType) {
            // key cannot be string
            if ($keyType instanceof \PHPStan\Type\Constant\ConstantStringType) {
                return \true;
            }
        }
        return \false;
    }
    private function isIteratorToArrayFuncCall(\PhpParser\Node\Expr $expr) : bool
    {
        return $this->nodeNameResolver->isFuncCallName($expr, 'iterator_to_array');
    }
}
