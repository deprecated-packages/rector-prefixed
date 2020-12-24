<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind;
use _PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver;
use _PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType;
/**
 * @see \Rector\Defluent\Tests\NodeFactory\FluentChainMethodCallRootExtractor\FluentChainMethodCallRootExtractorTest
 */
final class FluentChainMethodCallRootExtractor
{
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    /**
     * @var ExprStringTypeResolver
     */
    private $exprStringTypeResolver;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\Naming\Naming\PropertyNaming $propertyNaming, \_PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming\VariableNaming $variableNaming, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\ExprStringTypeResolver $exprStringTypeResolver, \_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->propertyNaming = $propertyNaming;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->exprStringTypeResolver = $exprStringTypeResolver;
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    /**
     * @param MethodCall[] $methodCalls
     */
    public function extractFromMethodCalls(array $methodCalls, string $kind) : ?\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        // we need at least 2 method call for fluent
        if (\count($methodCalls) < 2) {
            return null;
        }
        foreach ($methodCalls as $methodCall) {
            if ($methodCall->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable || $methodCall->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch) {
                return $this->createAssignAndRootExprForVariableOrPropertyFetch($methodCall);
            }
            if ($methodCall->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
                // direct = no parent
                if ($kind === \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FluentCallsKind::IN_ARGS) {
                    return $this->resolveKindInArgs($methodCall);
                }
                return $this->matchMethodCallOnNew($methodCall);
            }
        }
        return null;
    }
    /**
     * beware: fluent vs. factory
     * A. FLUENT: $cook->bake()->serve() // only "Cook"
     * B. FACTORY: $food = $cook->bake()->warmUp(); // only "Food"
     */
    public function resolveIsFirstMethodCallFactory(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $variableStaticType = $this->exprStringTypeResolver->resolve($methodCall->var);
        $calledMethodStaticType = $this->exprStringTypeResolver->resolve($methodCall);
        // get next method call
        $nextMethodCall = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$nextMethodCall instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $nestedCallStaticType = $this->exprStringTypeResolver->resolve($nextMethodCall);
        if ($nestedCallStaticType === null) {
            return \false;
        }
        if ($nestedCallStaticType !== $calledMethodStaticType) {
            return \false;
        }
        return $variableStaticType !== $calledMethodStaticType;
    }
    private function createAssignAndRootExprForVariableOrPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        $isFirstCallFactory = $this->resolveIsFirstMethodCallFactory($methodCall);
        // the method call, does not belong to the
        $staticType = $this->nodeTypeResolver->getStaticType($methodCall);
        $parentNode = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        // no assign
        if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            $variableName = $this->propertyNaming->fqnToVariableName($staticType);
            // the assign expresison must be break
            // pesuero code bsaed on type
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variableName);
            return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr($methodCall->var, $methodCall->var, $variable, $isFirstCallFactory);
        }
        return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr($methodCall->var, $methodCall->var, null, $isFirstCallFactory);
    }
    private function resolveKindInArgs(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        $variableName = $this->variableNaming->resolveFromNode($methodCall->var);
        if ($variableName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $silentVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variableName);
        return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr($methodCall->var, $methodCall->var, $silentVariable);
    }
    private function matchMethodCallOnNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr
    {
        // we need assigned left variable here
        $previousAssignOrReturn = $this->betterNodeFinder->findFirstPreviousOfTypes($methodCall->var, [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_::class]);
        if ($previousAssignOrReturn instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr($previousAssignOrReturn->var, $methodCall->var);
        }
        if ($previousAssignOrReturn instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Return_) {
            $className = $this->nodeNameResolver->getName($methodCall->var->class);
            if ($className === null) {
                return null;
            }
            $fullyQualifiedObjectType = new \_PhpScoperb75b35f52b74\Rector\PHPStan\Type\FullyQualifiedObjectType($className);
            $expectedName = $this->propertyNaming->getExpectedNameFromType($fullyQualifiedObjectType);
            if ($expectedName === null) {
                return null;
            }
            $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($expectedName->getName());
            return new \_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr($methodCall->var, $methodCall->var, $variable);
        }
        // no assign, just standalone call
        return null;
    }
}
