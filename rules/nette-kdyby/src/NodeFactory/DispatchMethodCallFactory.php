<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
final class DispatchMethodCallFactory
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->classNaming = $classNaming;
    }
    public function createFromEventClassName(string $eventClassName) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $shortEventClassName = $this->classNaming->getVariableName($eventClassName);
        $eventDispatcherPropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'eventDispatcher');
        $dispatchMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($eventDispatcherPropertyFetch, 'dispatch');
        $dispatchMethodCall->args[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($shortEventClassName));
        return $dispatchMethodCall;
    }
}
