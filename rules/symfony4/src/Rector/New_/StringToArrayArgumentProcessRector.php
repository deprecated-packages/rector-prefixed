<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\New_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTransformer;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symfony\Component\Console\Input\StringInput;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/27821/files
 * @see \Rector\Symfony4\Tests\Rector\New_\StringToArrayArgumentProcessRector\StringToArrayArgumentProcessRectorTest
 */
final class StringToArrayArgumentProcessRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NodeTransformer
     */
    private $nodeTransformer;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\NodeTransformer $nodeTransformer)
    {
        $this->nodeTransformer = $nodeTransformer;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes Process string argument to an array', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param New_|MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $expr = $node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ ? $node->class : $node->var;
        if ($this->isObjectType($expr, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Process\\Process')) {
            return $this->processArgumentPosition($node, 0);
        }
        if ($this->isObjectType($expr, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Helper\\ProcessHelper')) {
            return $this->processArgumentPosition($node, 1);
        }
        return null;
    }
    /**
     * @param New_|MethodCall $node
     */
    private function processArgumentPosition(\_PhpScoperb75b35f52b74\PhpParser\Node $node, int $argumentPosition) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!isset($node->args[$argumentPosition])) {
            return null;
        }
        $firstArgument = $node->args[$argumentPosition]->value;
        if ($firstArgument instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_) {
            return null;
        }
        // type analyzer
        if ($this->isStaticType($firstArgument, \_PhpScoperb75b35f52b74\PHPStan\Type\StringType::class)) {
            $this->processStringType($node, $argumentPosition, $firstArgument);
        }
        return $node;
    }
    /**
     * @param New_|MethodCall $expr
     */
    private function processStringType(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, int $argumentPosition, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $firstArgumentExpr) : void
    {
        if ($firstArgumentExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Concat) {
            $arrayNode = $this->nodeTransformer->transformConcatToStringArray($firstArgumentExpr);
            if ($arrayNode !== null) {
                $expr->args[$argumentPosition] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($arrayNode);
            }
            return;
        }
        if ($firstArgumentExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall && $this->isFuncCallName($firstArgumentExpr, 'sprintf')) {
            $arrayNode = $this->nodeTransformer->transformSprintfToArray($firstArgumentExpr);
            if ($arrayNode !== null) {
                $expr->args[$argumentPosition]->value = $arrayNode;
            }
        } elseif ($firstArgumentExpr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
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
        $privatesCaller = new \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Reflection\PrivatesCaller();
        return $privatesCaller->callPrivateMethod(new \_PhpScoperb75b35f52b74\Symfony\Component\Console\Input\StringInput(''), 'tokenize', $process);
    }
    private function processPreviousAssign(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $firstArgumentExpr) : void
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
    private function findPreviousNodeAssign(\_PhpScoperb75b35f52b74\PhpParser\Node $node, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $firstArgumentExpr) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        /** @var Assign|null $assign */
        $assign = $this->betterNodeFinder->findFirstPrevious($node, function (\_PhpScoperb75b35f52b74\PhpParser\Node $checkedNode) use($firstArgumentExpr) : ?Assign {
            if (!$checkedNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
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
