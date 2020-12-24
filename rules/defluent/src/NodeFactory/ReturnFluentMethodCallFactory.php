<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FirstAssignFluentCall;
use _PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls;
use _PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallRootExtractor $fluentChainMethodCallRootExtractor, \_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->fluentChainMethodCallRootExtractor = $fluentChainMethodCallRootExtractor;
        $this->nodeTypeResolver = $nodeTypeResolver;
        $this->propertyNaming = $propertyNaming;
    }
    public function createFromFluentMethodCalls(\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FluentMethodCalls $fluentMethodCalls) : ?\_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FirstAssignFluentCall
    {
        $rootMethodCall = $fluentMethodCalls->getRootMethodCall();
        // this means the 1st method creates different object then it runs on
        // e.g. $sheet->getRow(), creates a "Row" object
        $isFirstMethodCallFactory = $this->fluentChainMethodCallRootExtractor->resolveIsFirstMethodCallFactory($rootMethodCall);
        $lastMethodCall = $fluentMethodCalls->getRootMethodCall();
        if ($lastMethodCall->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
            $assignExpr = $lastMethodCall->var;
        } else {
            // we need a variable to assign the stuff into
            // the method call, does not belong to the
            $staticType = $this->nodeTypeResolver->getStaticType($rootMethodCall);
            if (!$staticType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
                return null;
            }
            $variableName = $this->propertyNaming->fqnToVariableName($staticType);
            $assignExpr = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable($variableName);
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\Defluent\ValueObject\FirstAssignFluentCall($assignExpr, $rootMethodCall, $isFirstMethodCallFactory, $fluentMethodCalls);
    }
}
