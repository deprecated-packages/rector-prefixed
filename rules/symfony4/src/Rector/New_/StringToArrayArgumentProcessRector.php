<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony4\Rector\New_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\StringType;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTransformer;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\StringInput;
use _PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/27821/files
 * @see \Rector\Symfony4\Tests\Rector\New_\StringToArrayArgumentProcessRector\StringToArrayArgumentProcessRectorTest
 */
final class StringToArrayArgumentProcessRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NodeTransformer
     */
    private $nodeTransformer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\NodeTransformer $nodeTransformer)
    {
        $this->nodeTransformer = $nodeTransformer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Process string argument to an array', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Process\Process;
$process = new Process('ls -l');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Process\Process;
$process = new Process(['ls', '-l']);
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param New_|MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $expr = $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_ ? $node->class : $node->var;
        if ($this->isObjectType($expr, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Process\\Process')) {
            return $this->processArgumentPosition($node, 0);
        }
        if ($this->isObjectType($expr, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Console\\Helper\\ProcessHelper')) {
            return $this->processArgumentPosition($node, 1);
        }
        return null;
    }
    /**
     * @param New_|MethodCall $node
     */
    private function processArgumentPosition(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, int $argumentPosition) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!isset($node->args[$argumentPosition])) {
            return null;
        }
        $firstArgument = $node->args[$argumentPosition]->value;
        if ($firstArgument instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_) {
            return null;
        }
        // type analyzer
        if ($this->isStaticType($firstArgument, \_PhpScoper0a2ac50786fa\PHPStan\Type\StringType::class)) {
            $this->processStringType($node, $argumentPosition, $firstArgument);
        }
        return $node;
    }
    /**
     * @param New_|MethodCall $expr
     */
    private function processStringType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, int $argumentPosition, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $firstArgumentExpr) : void
    {
        if ($firstArgumentExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Concat) {
            $arrayNode = $this->nodeTransformer->transformConcatToStringArray($firstArgumentExpr);
            if ($arrayNode !== null) {
                $expr->args[$argumentPosition] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($arrayNode);
            }
            return;
        }
        if ($firstArgumentExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall && $this->isFuncCallName($firstArgumentExpr, 'sprintf')) {
            $arrayNode = $this->nodeTransformer->transformSprintfToArray($firstArgumentExpr);
            if ($arrayNode !== null) {
                $expr->args[$argumentPosition]->value = $arrayNode;
            }
        } elseif ($firstArgumentExpr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_) {
            $parts = $this->splitProcessCommandToItems($firstArgumentExpr->value);
            $expr->args[$argumentPosition]->value = $this->createArray($parts);
        }
        $this->processPreviousAssign($expr, $firstArgumentExpr);
    }
    /**
     * @return string[]
     */
    private function splitProcessCommandToItems(string $process) : array
    {
        $privatesCaller = new \_PhpScoper0a2ac50786fa\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        return $privatesCaller->callPrivateMethod(new \_PhpScoper0a2ac50786fa\Symfony\Component\Console\Input\StringInput(''), 'tokenize', $process);
    }
    private function processPreviousAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $firstArgumentExpr) : void
    {
        $previousNodeAssign = $this->findPreviousNodeAssign($node, $firstArgumentExpr);
        if ($previousNodeAssign === null) {
            return;
        }
        if (!$this->isFuncCallName($previousNodeAssign->expr, 'sprintf')) {
            return;
        }
        /** @var FuncCall $funcCall */
        $funcCall = $previousNodeAssign->expr;
        $arrayNode = $this->nodeTransformer->transformSprintfToArray($funcCall);
        if ($arrayNode !== null) {
            $previousNodeAssign->expr = $arrayNode;
        }
    }
    private function findPreviousNodeAssign(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $firstArgumentExpr) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign
    {
        /** @var Assign|null $assign */
        $assign = $this->betterNodeFinder->findFirstPrevious($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $checkedNode) use($firstArgumentExpr) : ?Assign {
            if (!$checkedNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
                return null;
            }
            if (!$this->areNodesEqual($checkedNode->var, $firstArgumentExpr)) {
                return null;
            }
            return $checkedNode;
        });
        return $assign;
    }
}
