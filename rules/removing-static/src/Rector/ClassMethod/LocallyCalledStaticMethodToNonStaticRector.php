<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\RemovingStatic\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector\LocallyCalledStaticMethodToNonStaticRectorTest
 */
final class LocallyCalledStaticMethodToNonStaticRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static method and local-only calls to non-static', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        self::someStatic();
    }

    private static function someStatic()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $this->someStatic();
    }

    private function someStatic()
    {
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param ClassMethod|StaticCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        return $this->refactorStaticCall($node);
    }
    private function refactorClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod
    {
        if (!$classMethod->isStatic()) {
            return null;
        }
        if (!$this->isClassMethodWithOnlyLocalStaticCalls($classMethod)) {
            return null;
        }
        // change static calls to non-static ones, but only if in non-static method!!!
        $this->makeNonStatic($classMethod);
        return $classMethod;
    }
    private function refactorStaticCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        $classMethod = $this->nodeRepository->findClassMethodByStaticCall($staticCall);
        if ($classMethod === null) {
            return null;
        }
        // is static call in the same as class method
        if (!$this->haveSharedClass($classMethod, [$staticCall])) {
            return null;
        }
        if ($this->isInStaticClassMethod($staticCall)) {
            return null;
        }
        $thisVariable = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('this');
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall($thisVariable, $staticCall->name, $staticCall->args);
    }
    private function isClassMethodWithOnlyLocalStaticCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $staticCalls = $this->nodeRepository->findStaticCallsByClassMethod($classMethod);
        // get static staticCalls
        return $this->haveSharedClass($classMethod, $staticCalls);
    }
    /**
     * @param Node[] $nodes
     */
    private function haveSharedClass(\_PhpScoper0a2ac50786fa\PhpParser\Node $mainNode, array $nodes) : bool
    {
        $mainNodeClass = $mainNode->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($nodes as $node) {
            $nodeClass = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($mainNodeClass !== $nodeClass) {
                return \false;
            }
        }
        return \true;
    }
    private function isInStaticClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        /** @var ClassMethod|null $locationClassMethod */
        $locationClassMethod = $staticCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($locationClassMethod === null) {
            return \false;
        }
        return $locationClassMethod->isStatic();
    }
}
