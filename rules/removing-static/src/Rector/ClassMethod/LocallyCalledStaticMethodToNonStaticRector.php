<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\RemovingStatic\Rector\ClassMethod;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\RemovingStatic\Tests\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector\LocallyCalledStaticMethodToNonStaticRectorTest
 */
final class LocallyCalledStaticMethodToNonStaticRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static method and local-only calls to non-static', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param ClassMethod|StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            return $this->refactorClassMethod($node);
        }
        return $this->refactorStaticCall($node);
    }
    private function refactorClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
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
    private function refactorStaticCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
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
        $thisVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this');
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($thisVariable, $staticCall->name, $staticCall->args);
    }
    private function isClassMethodWithOnlyLocalStaticCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $staticCalls = $this->nodeRepository->findStaticCallsByClassMethod($classMethod);
        // get static staticCalls
        return $this->haveSharedClass($classMethod, $staticCalls);
    }
    /**
     * @param Node[] $nodes
     */
    private function haveSharedClass(\_PhpScoperb75b35f52b74\PhpParser\Node $mainNode, array $nodes) : bool
    {
        $mainNodeClass = $mainNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($nodes as $node) {
            $nodeClass = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
            if ($mainNodeClass !== $nodeClass) {
                return \false;
            }
        }
        return \true;
    }
    private function isInStaticClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        /** @var ClassMethod|null $locationClassMethod */
        $locationClassMethod = $staticCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($locationClassMethod === null) {
            return \false;
        }
        return $locationClassMethod->isStatic();
    }
}
