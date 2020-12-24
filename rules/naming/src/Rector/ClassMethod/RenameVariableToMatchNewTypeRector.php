<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Naming\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Naming\Guard\BreakingVariableRenameGuard;
use _PhpScoper0a6b37af0871\Rector\Naming\Naming\ExpectedNameResolver;
use _PhpScoper0a6b37af0871\Rector\Naming\VariableRenamer;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Naming\Tests\Rector\ClassMethod\RenameVariableToMatchNewTypeRector\RenameVariableToMatchNewTypeRectorTest
 */
final class RenameVariableToMatchNewTypeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ExpectedNameResolver
     */
    private $expectedNameResolver;
    /**
     * @var BreakingVariableRenameGuard
     */
    private $breakingVariableRenameGuard;
    /**
     * @var VariableRenamer
     */
    private $variableRenamer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard, \_PhpScoper0a6b37af0871\Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver, \_PhpScoper0a6b37af0871\Rector\Naming\VariableRenamer $variableRenamer)
    {
        $this->expectedNameResolver = $expectedNameResolver;
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->variableRenamer = $variableRenamer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Rename variable to match new ClassType', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $search = new DreamSearch();
        $search->advance();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $dreamSearch = new DreamSearch();
        $dreamSearch->advance();
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $hasChanged = \false;
        $assignsOfNew = $this->getAssignsOfNew($node);
        foreach ($assignsOfNew as $assign) {
            $expectedName = $this->expectedNameResolver->resolveForAssignNew($assign);
            /** @var Variable $variable */
            $variable = $assign->var;
            if ($expectedName === null || $this->isName($variable, $expectedName)) {
                continue;
            }
            $currentName = $this->getName($variable);
            if ($currentName === null) {
                continue;
            }
            if ($this->breakingVariableRenameGuard->shouldSkipVariable($currentName, $expectedName, $node, $variable)) {
                continue;
            }
            $hasChanged = \true;
            // 1. rename assigned variable
            $assign->var = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($expectedName);
            // 2. rename variable in the
            $this->variableRenamer->renameVariableInFunctionLike($node, $assign, $currentName, $expectedName);
        }
        if (!$hasChanged) {
            return null;
        }
        return $node;
    }
    /**
     * @return Assign[]
     */
    private function getAssignsOfNew(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        /** @var Assign[] $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array) $classMethod->stmts, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign::class);
        return \array_filter($assigns, function (\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign $assign) : bool {
            return $assign->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
        });
    }
}
