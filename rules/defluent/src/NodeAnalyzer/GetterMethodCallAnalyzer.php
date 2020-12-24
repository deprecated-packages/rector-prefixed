<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver;
final class GetterMethodCallAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isGetterMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodCallStaticType = $this->nodeTypeResolver->getStaticType($methodCall);
        $methodCallVarStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        // getter short call type
        return !$methodCallStaticType->equals($methodCallVarStaticType);
    }
}
