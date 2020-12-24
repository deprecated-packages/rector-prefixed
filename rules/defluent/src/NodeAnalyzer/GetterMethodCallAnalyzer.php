<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class GetterMethodCallAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isGetterMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        $methodCallStaticType = $this->nodeTypeResolver->getStaticType($methodCall);
        $methodCallVarStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        // getter short call type
        return !$methodCallStaticType->equals($methodCallVarStaticType);
    }
}
