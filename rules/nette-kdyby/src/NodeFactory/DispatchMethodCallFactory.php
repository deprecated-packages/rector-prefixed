<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
final class DispatchMethodCallFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    public function createFromEventClassName(string $eventClassName) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $shortEventClassName = $this->classNaming->getVariableName($eventClassName);
        $eventDispatcherPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), 'eventDispatcher');
        $dispatchMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($eventDispatcherPropertyFetch, 'dispatch');
        $dispatchMethodCall->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($shortEventClassName));
        return $dispatchMethodCall;
    }
}
