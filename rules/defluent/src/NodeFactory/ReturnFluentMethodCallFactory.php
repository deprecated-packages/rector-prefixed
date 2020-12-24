<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\FirstAssignFluentCall;
use _PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentMethodCalls;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class ReturnFluentMethodCallFactory
{
    /**
     * @var FluentChainMethodCallRootExtractor
     */
    private $fluentChainMethodCallRootExtractor;
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor $fluentChainMethodCallRootExtractor, \_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->fluentChainMethodCallRootExtractor = $fluentChainMethodCallRootExtractor;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->propertyNaming = $propertyNaming;
    }
    public function createFromFluentMethodCalls(\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls) : ?\_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FirstAssignFluentCall
    {
        $rootMethodCall = $fluentMethodCalls->getRootMethodCall();
        // this means the 1st method creates different object then it runs on
        // e.g. $sheet->getRow(), creates a "Row" object
        $isFirstMethodCallFactory = $this->fluentChainMethodCallRootExtractor->resolveIsFirstMethodCallFactory($rootMethodCall);
        $lastMethodCall = $fluentMethodCalls->getRootMethodCall();
        if ($lastMethodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch) {
            $assignExpr = $lastMethodCall->var;
        } else {
            // we need a variable to assign the stuff into
            // the method call, does not belong to the
            $staticType = $this->nodeTypeResolver->getStaticType($rootMethodCall);
            if (!$staticType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType) {
                return null;
            }
            $variableName = $this->propertyNaming->fqnToVariableName($staticType);
            $assignExpr = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
        }
        return new \_PhpScopere8e811afab72\Rector\Defluent\ValueObject\FirstAssignFluentCall($assignExpr, $rootMethodCall, $isFirstMethodCallFactory, $fluentMethodCalls);
    }
}
