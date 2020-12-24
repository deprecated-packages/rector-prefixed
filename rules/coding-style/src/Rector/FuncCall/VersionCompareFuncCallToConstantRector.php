<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\FuncCall;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\FuncCall\VersionCompareFuncCallToConstantRector\VersionCompareFuncCallToConstantRectorTest
 */
final class VersionCompareFuncCallToConstantRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const OPERATOR_TO_COMPARISON = ['=' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class, '==' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class, 'eq' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Identical::class, '!=' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, '<>' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, 'ne' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\NotIdentical::class, '>' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater::class, 'gt' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Greater::class, '<' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller::class, 'lt' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\Smaller::class, '>=' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, 'ge' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\GreaterOrEqual::class, '<=' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class, 'le' => \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\BinaryOp\SmallerOrEqual::class];
    /**
     * @var string
     * @see https://regex101.com/r/yl9g25/1
     */
    private const SEMANTIC_VERSION_REGEX = '#^\\d+\\.\\d+\\.\\d+$#';
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes use of call to version compare function to use of PHP version constant', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
    private function isPhpVersionConstant(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch) {
            return \false;
        }
        return $expr->name->toString() === 'PHP_VERSION';
    }
    private function getNewNodeForArg(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr
    {
        if ($this->isPhpVersionConstant($expr)) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('PHP_VERSION_ID'));
        }
        return $this->getVersionNumberFormVersionString($expr);
    }
    private function getVersionNumberFormVersionString(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        if (!\_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($expr->value, self::SEMANTIC_VERSION_REGEX)) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $versionParts = \explode('.', $expr->value);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\LNumber((int) $versionParts[0] * 10000 + (int) $versionParts[1] * 100 + (int) $versionParts[2]);
    }
}
