<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\FuncCall;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\FuncCall\VersionCompareFuncCallToConstantRector\VersionCompareFuncCallToConstantRectorTest
 */
final class VersionCompareFuncCallToConstantRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OPERATOR_TO_COMPARISON = ['=' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, '==' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, 'eq' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Identical::class, '!=' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, '<>' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, 'ne' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, '>' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater::class, 'gt' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Greater::class, '<' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller::class, 'lt' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\Smaller::class, '>=' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, 'ge' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, '<=' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, 'le' => \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class];
    /**
     * @var string
     * @see https://regex101.com/r/yl9g25/1
     */
    private const SEMANTIC_VERSION_REGEX = '#^\\d+\\.\\d+\\.\\d+$#';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes use of call to version compare function to use of PHP version constant', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        version_compare(PHP_VERSION, '5.3.0', '<');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        PHP_VERSION_ID < 50300;
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node, 'version_compare')) {
            return null;
        }
        if (\count((array) $node->args) !== 3) {
            return null;
        }
        if (!$this->isPhpVersionConstant($node->args[0]->value) && !$this->isPhpVersionConstant($node->args[1]->value)) {
            return null;
        }
        $left = $this->getNewNodeForArg($node->args[0]->value);
        $right = $this->getNewNodeForArg($node->args[1]->value);
        /** @var String_ $operator */
        $operator = $node->args[2]->value;
        $comparisonClass = self::OPERATOR_TO_COMPARISON[$operator->value];
        return new $comparisonClass($left, $right);
    }
    private function isPhpVersionConstant(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $expr->name->toString() === 'PHP_VERSION';
    }
    private function getNewNodeForArg(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Expr
    {
        if ($this->isPhpVersionConstant($expr)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name('PHP_VERSION_ID'));
        }
        return $this->getVersionNumberFormVersionString($expr);
    }
    private function getVersionNumberFormVersionString(\_PhpScopere8e811afab72\PhpParser\Node\Expr $expr) : \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber
    {
        if (!$expr instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::match($expr->value, self::SEMANTIC_VERSION_REGEX)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $versionParts = \explode('.', $expr->value);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\LNumber((int) $versionParts[0] * 10000 + (int) $versionParts[1] * 100 + (int) $versionParts[2]);
    }
}
