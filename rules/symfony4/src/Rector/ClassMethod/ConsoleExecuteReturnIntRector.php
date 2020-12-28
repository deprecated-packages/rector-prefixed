<?php

declare (strict_types=1);
namespace Rector\Symfony4\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\BinaryOp\Coalesce;
use PhpParser\Node\Expr\Cast\Int_;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\FunctionLike;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeTraverser;
use PHPStan\Type\IntegerType;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/33775/files
 * @see \Rector\Symfony4\Tests\Rector\ClassMethod\ConsoleExecuteReturnIntRector\ConsoleExecuteReturnIntRectorTest
 */
final class ConsoleExecuteReturnIntRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Returns int from Command::execute command', [new \RectorPrefix20201228\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        return null;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeCommand extends Command
{
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return 0;
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node, 'execute')) {
            return null;
        }
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if (!$this->isObjectType($classLike, 'Symfony\\Component\\Console\\Command\\Command')) {
            return null;
        }
        $this->refactorReturnTypeDeclaration($node);
        $this->addReturn0ToMethod($node);
        return $node;
    }
    private function refactorReturnTypeDeclaration(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // already set
        if ($classMethod->returnType !== null && $this->isName($classMethod->returnType, 'int')) {
            return;
        }
        $classMethod->returnType = new \PhpParser\Node\Identifier('int');
    }
    private function addReturn0ToMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $hasReturn = \false;
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\PhpParser\Node $node) use($classMethod, &$hasReturn) : ?int {
            if ($node instanceof \PhpParser\Node\FunctionLike) {
                return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr instanceof \PhpParser\Node\Expr\Cast\Int_) {
                return null;
            }
            // is there return without nesting?
            $parentNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($this->areNodesEqual($parentNode, $classMethod)) {
                $hasReturn = \true;
            }
            $this->setReturnTo0InsteadOfNull($node);
            return null;
        });
        if ($hasReturn) {
            return;
        }
        $classMethod->stmts[] = new \PhpParser\Node\Stmt\Return_(new \PhpParser\Node\Scalar\LNumber(0));
    }
    private function setReturnTo0InsteadOfNull(\PhpParser\Node\Stmt\Return_ $return) : void
    {
        if ($return->expr === null) {
            $return->expr = new \PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($this->isNull($return->expr)) {
            $return->expr = new \PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \PhpParser\Node\Expr\BinaryOp\Coalesce && $this->isNull($return->expr->right)) {
            $return->expr->right = new \PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \PhpParser\Node\Expr\Ternary) {
            $hasChanged = $this->isSuccessfulRefactorTernaryReturn($return->expr);
            if ($hasChanged) {
                return;
            }
        }
        $staticType = $this->getStaticType($return->expr);
        if (!$staticType instanceof \PHPStan\Type\IntegerType) {
            $return->expr = new \PhpParser\Node\Expr\Cast\Int_($return->expr);
            return;
        }
    }
    private function isSuccessfulRefactorTernaryReturn(\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        $hasChanged = \false;
        if ($ternary->if && $this->isNull($ternary->if)) {
            $ternary->if = new \PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        if ($this->isNull($ternary->else)) {
            $ternary->else = new \PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        return $hasChanged;
    }
}
