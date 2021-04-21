<?php

declare (strict_types=1);
namespace Rector\Defluent\NodeAnalyzer;

use PhpParser\Node\Expr\MethodCall;
use Rector\NodeTypeResolver\NodeTypeResolver;
final class GetterMethodCallAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isGetterMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodCallStaticType = $this->nodeTypeResolver->getStaticType($methodCall);
        $methodCallVarStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        // getter short call type
        return !$methodCallStaticType->equals($methodCallVarStaticType);
    }
}
