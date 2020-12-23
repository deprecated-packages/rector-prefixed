<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Defluent\ValueObject;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
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
    public function __construct(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $rootMethodCall, array $fluentMethodCalls, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $lastMethodCall)
    {
        $this->rootMethodCall = $rootMethodCall;
        $this->fluentMethodCalls = $fluentMethodCalls;
        $this->lastMethodCall = $lastMethodCall;
    }
    public function getRootMethodCall() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
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
    public function getLastMethodCall() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        return $this->lastMethodCall;
    }
}
