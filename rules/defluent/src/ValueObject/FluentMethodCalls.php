<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
final class FluentMethodCalls
{
    /**
     * @var MethodCall[]
     */
    private $fluentMethodCalls = [];
    /**
     * @var MethodCall
     */
    private $rootMethodCall;
    /**
     * @var MethodCall
     */
    private $lastMethodCall;
    /**
     * @param MethodCall[] $fluentMethodCalls
     */
    public function __construct(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $rootMethodCall, array $fluentMethodCalls, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $lastMethodCall)
    {
        $this->rootMethodCall = $rootMethodCall;
        $this->fluentMethodCalls = $fluentMethodCalls;
        $this->lastMethodCall = $lastMethodCall;
    }
    public function getRootMethodCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        return $this->rootMethodCall;
    }
    /**
     * @return MethodCall[]
     */
    public function getFluentMethodCalls() : array
    {
        return $this->fluentMethodCalls;
    }
    public function getLastMethodCall() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        return $this->lastMethodCall;
    }
}
