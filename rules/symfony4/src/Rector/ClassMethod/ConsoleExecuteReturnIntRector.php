<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony4\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary;
use _PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/33775/files
 * @see \Rector\Symfony4\Tests\Rector\ClassMethod\ConsoleExecuteReturnIntRector\ConsoleExecuteReturnIntRectorTest
 */
final class ConsoleExecuteReturnIntRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Returns int from Command::execute command', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node, 'execute')) {
            return null;
        }
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if (!$this->isObjectType($classLike, '_PhpScoperb75b35f52b74\\Symfony\\Component\\Console\\Command\\Command')) {
            return null;
        }
        $this->refactorReturnTypeDeclaration($node);
        $this->addReturn0ToMethod($node);
        return $node;
    }
    private function refactorReturnTypeDeclaration(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // already set
        if ($classMethod->returnType !== null && $this->isName($classMethod->returnType, 'int')) {
            return;
        }
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('int');
    }
    private function addReturn0ToMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $hasReturn = \false;
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($classMethod, &$hasReturn) : ?int {
            if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\FunctionLike) {
                return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_) {
                return null;
            }
            // is there return without nesting?
            $parentNode = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($this->areNodesEqual($parentNode, $classMethod)) {
                $hasReturn = \true;
            }
            $this->setReturnTo0InsteadOfNull($node);
            return null;
        });
        if ($hasReturn) {
            return;
        }
        $classMethod->stmts[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0));
    }
    private function setReturnTo0InsteadOfNull(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_ $return) : void
    {
        if ($return->expr === null) {
            $return->expr = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($this->isNull($return->expr)) {
            $return->expr = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce && $this->isNull($return->expr->right)) {
            $return->expr->right = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary) {
            $hasChanged = $this->isSuccessfulRefactorTernaryReturn($return->expr);
            if ($hasChanged) {
                return;
            }
        }
        $staticType = $this->getStaticType($return->expr);
        if (!$staticType instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType) {
            $return->expr = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Cast\Int_($return->expr);
            return;
        }
    }
    private function isSuccessfulRefactorTernaryReturn(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        $hasChanged = \false;
        if ($ternary->if && $this->isNull($ternary->if)) {
            $ternary->if = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        if ($this->isNull($ternary->else)) {
            $ternary->else = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        return $hasChanged;
    }
}
