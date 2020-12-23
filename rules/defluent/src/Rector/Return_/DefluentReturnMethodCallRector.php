<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\Rector\Return_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a2ac50786fa\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Defluent\Tests\Rector\Return_\DefluentReturnMethodCallRector\DefluentReturnMethodCallRectorTest
 */
final class DefluentReturnMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Defluent\Rector\AbstractFluentChainMethodCallRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns return of fluent, to standalone call line and return of value', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$someClass = new SomeClass();
return $someClass->someFunction();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someClass = new SomeClass();
$someClass->someFunction();
return $someClass;
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_::class];
    }
    /**
     * @param Return_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$node->expr instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        $methodCall = $node->expr;
        if (!$methodCall->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable) {
            return null;
        }
        if (!$this->fluentChainMethodCallNodeAnalyzer->isFluentClassMethodOfMethodCall($methodCall)) {
            return null;
        }
        $variableReturn = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Return_($methodCall->var);
        $this->addNodesAfterNode([$methodCall, $variableReturn], $node);
        $this->removeNode($node);
        return null;
    }
}
