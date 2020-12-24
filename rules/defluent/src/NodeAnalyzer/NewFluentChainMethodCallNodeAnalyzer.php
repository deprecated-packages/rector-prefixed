<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver;
final class NewFluentChainMethodCallNodeAnalyzer
{
    /**
     * @var NodeTypeResolver
     */
    private $nodeTypeResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\NodeTypeResolver $nodeTypeResolver)
    {
        $this->nodeTypeResolver = $nodeTypeResolver;
    }
    public function isNewMethodCallReturningSelf(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $newStaticType = $this->nodeTypeResolver->getStaticType($methodCall->var);
        $methodCallStaticType = $this->nodeTypeResolver->getStaticType($methodCall);
        return $methodCallStaticType->equals($newStaticType);
    }
    /**
     * Method call with "new X", that returns "X"?
     * e.g.
     *
     * $this->setItem(new Item) // → returns "Item"
     */
    public function matchNewInFluentSetterMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_
    {
        if (\count((array) $methodCall->args) !== 1) {
            return null;
        }
        $onlyArgValue = $methodCall->args[0]->value;
        if (!$onlyArgValue instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_) {
            return null;
        }
        $newType = $this->nodeTypeResolver->resolve($onlyArgValue);
        if ($newType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
            return null;
        }
        $parentMethodCallReturnType = $this->nodeTypeResolver->resolve($methodCall);
        if (!$newType->equals($parentMethodCallReturnType)) {
            return null;
        }
        return $onlyArgValue;
    }
}
