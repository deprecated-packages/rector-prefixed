<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony4\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Int_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary;
use _PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/symfony/symfony/pull/33775/files
 * @see \Rector\Symfony4\Tests\Rector\ClassMethod\ConsoleExecuteReturnIntRector\ConsoleExecuteReturnIntRectorTest
 */
final class ConsoleExecuteReturnIntRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Returns int from Command::execute command', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isName($node, 'execute')) {
            return null;
        }
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Console\\Command\\Command')) {
            return null;
        }
        $this->refactorReturnTypeDeclaration($node);
        $this->addReturn0ToMethod($node);
        return $node;
    }
    private function refactorReturnTypeDeclaration(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // already set
        if ($classMethod->returnType !== null && $this->isName($classMethod->returnType, 'int')) {
            return;
        }
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('int');
    }
    private function addReturn0ToMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $hasReturn = \false;
        $this->traverseNodesWithCallable((array) $classMethod->getStmts(), function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($classMethod, &$hasReturn) : ?int {
            if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\FunctionLike) {
                return \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
            }
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            if ($node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Int_) {
                return null;
            }
            // is there return without nesting?
            $parentNode = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($this->areNodesEqual($parentNode, $classMethod)) {
                $hasReturn = \true;
            }
            $this->setReturnTo0InsteadOfNull($node);
            return null;
        });
        if ($hasReturn) {
            return;
        }
        $classMethod->stmts[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0));
    }
    private function setReturnTo0InsteadOfNull(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_ $return) : void
    {
        if ($return->expr === null) {
            $return->expr = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($this->isNull($return->expr)) {
            $return->expr = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\BinaryOp\Coalesce && $this->isNull($return->expr->right)) {
            $return->expr->right = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0);
            return;
        }
        if ($return->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary) {
            $hasChanged = $this->isSuccessfulRefactorTernaryReturn($return->expr);
            if ($hasChanged) {
                return;
            }
        }
        $staticType = $this->getStaticType($return->expr);
        if (!$staticType instanceof \_PhpScoper0a2ac50786fa\PHPStan\Type\IntegerType) {
            $return->expr = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Cast\Int_($return->expr);
            return;
        }
    }
    private function isSuccessfulRefactorTernaryReturn(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Ternary $ternary) : bool
    {
        $hasChanged = \false;
        if ($ternary->if && $this->isNull($ternary->if)) {
            $ternary->if = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        if ($this->isNull($ternary->else)) {
            $ternary->else = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\LNumber(0);
            $hasChanged = \true;
        }
        return $hasChanged;
    }
}
