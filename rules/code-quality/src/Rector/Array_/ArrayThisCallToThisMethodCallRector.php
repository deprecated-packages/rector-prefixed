<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodeQuality\Rector\Array_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeCollector\NodeAnalyzer\ArrayCallableMethodReferenceAnalyzer;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodeQuality\Tests\Rector\Array_\ArrayThisCallToThisMethodCallRector\ArrayThisCallToThisMethodCallRectorTest
 */
final class ArrayThisCallToThisMethodCallRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ArrayCallableMethodReferenceAnalyzer
     */
    private $arrayCallableMethodReferenceAnalyzer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeCollector\NodeAnalyzer\ArrayCallableMethodReferenceAnalyzer $arrayCallableMethodReferenceAnalyzer)
    {
        $this->arrayCallableMethodReferenceAnalyzer = $arrayCallableMethodReferenceAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change `[$this, someMethod]` without any args to $this->someMethod()', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $values = [$this, 'giveMeMore'];
    }

    public function giveMeMore()
    {
        return 'more';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        $values = $this->giveMeMore();
    }

    public function giveMeMore()
    {
        return 'more';
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_::class];
    }
    /**
     * @param Array_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $arrayCallable = $this->arrayCallableMethodReferenceAnalyzer->match($node);
        if ($arrayCallable === null) {
            return null;
        }
        if ($this->isAssignedToNetteMagicOnProperty($node) || $this->isInsideProperty($node)) {
            return null;
        }
        $parentNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // skip if part of method
        if ($parentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Arg) {
            return null;
        }
        if (!$arrayCallable->isExistingMethod()) {
            return null;
        }
        $reflectionMethod = $arrayCallable->getReflectionMethod();
        if ($reflectionMethod->getNumberOfParameters() > 0) {
            $classMethod = $this->nodeRepository->findClassMethod($arrayCallable->getClass(), $arrayCallable->getMethod());
            if ($classMethod !== null) {
                return $this->nodeFactory->createClosureFromClassMethod($classMethod);
            }
            return null;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), $arrayCallable->getMethod());
    }
    private function isAssignedToNetteMagicOnProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : bool
    {
        $parent = $array->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if (!$parent->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if (!$parent->var->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        /** @var PropertyFetch $propertyFetch */
        $propertyFetch = $parent->var->var;
        return $this->isName($propertyFetch->name, 'on*');
    }
    private function isInsideProperty(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_ $array) : bool
    {
        $parentProperty = $this->betterNodeFinder->findFirstParentInstanceOf($array, [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class]);
        return $parentProperty !== null;
    }
}
