<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php72\Rector\FuncCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see http://php.net/manual/en/migration72.incompatible.php#migration72.incompatible.is_object-on-incomplete_class
 * @see https://3v4l.org/SpiE6
 *
 * @see \Rector\Php72\Tests\Rector\FuncCall\IsObjectOnIncompleteClassRector\IsObjectOnIncompleteClassRectorTest
 */
final class IsObjectOnIncompleteClassRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Incomplete class returns inverted bool on is_object()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$incompleteObject = new __PHP_Incomplete_Class;
$isObject = is_object($incompleteObject);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$incompleteObject = new __PHP_Incomplete_Class;
$isObject = ! is_object($incompleteObject);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'is_object')) {
            return null;
        }
        $incompleteClassObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('__PHP_Incomplete_Class');
        if (!$this->isObjectType($node->args[0]->value, $incompleteClassObjectType)) {
            return null;
        }
        if ($this->shouldSkip($node)) {
            return null;
        }
        $booleanNot = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot($node);
        $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE, $booleanNot);
        return $booleanNot;
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : bool
    {
        $parentNode = $funcCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        return $parentNode instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\BooleanNot;
    }
}
