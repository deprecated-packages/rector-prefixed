<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\DataProvider;

use _PhpScoper2a4e7ab1ecbc\Nette\Application\UI\Control;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
final class OnPropertyMagicCallProvider
{
    /**
     * @var MethodCall[]
     */
    private $onPropertyMagicCalls = [];
    /**
     * @var NodeRepository
     */
    private $nodeRepository;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return MethodCall[]
     */
    public function provide() : array
    {
        if ($this->onPropertyMagicCalls !== [] && !\_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            return $this->onPropertyMagicCalls;
        }
        foreach ($this->nodeRepository->getMethodsCalls() as $methodCall) {
            if (!$this->isLocalOnPropertyCall($methodCall)) {
                continue;
            }
            $this->onPropertyMagicCalls[] = $methodCall;
        }
        return $this->onPropertyMagicCalls;
    }
    /**
     * Detects method call on, e.g:
     * public $onSomeProperty;
     */
    private function isLocalOnPropertyCall(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($methodCall->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($methodCall->var, 'this')) {
            return \false;
        }
        if (!$this->nodeNameResolver->isName($methodCall->name, 'on*')) {
            return \false;
        }
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        if ($methodName === null) {
            return \false;
        }
        $className = $methodCall->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        // control event, inner only
        if (\is_a($className, \_PhpScoper2a4e7ab1ecbc\Nette\Application\UI\Control::class, \true)) {
            return \false;
        }
        if (\method_exists($className, $methodName)) {
            return \false;
        }
        return \property_exists($className, $methodName);
    }
}
