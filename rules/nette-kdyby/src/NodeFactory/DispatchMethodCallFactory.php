<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteKdyby\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming;
final class DispatchMethodCallFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    public function createFromEventClassName(string $eventClassName) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        $shortEventClassName = $this->classNaming->getVariableName($eventClassName);
        $eventDispatcherPropertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), 'eventDispatcher');
        $dispatchMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($eventDispatcherPropertyFetch, 'dispatch');
        $dispatchMethodCall->args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable($shortEventClassName));
        return $dispatchMethodCall;
    }
}
