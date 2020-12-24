<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\DataProvider;

use _PhpScopere8e811afab72\Nette\Application\UI\Control;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
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
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector\NodeRepository $nodeRepository)
    {
        $this->nodeRepository = $nodeRepository;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return MethodCall[]
     */
    public function provide() : array
    {
        if ($this->onPropertyMagicCalls !== [] && !\_PhpScopere8e811afab72\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
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
    private function isLocalOnPropertyCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if ($methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($methodCall->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
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
        $className = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        // control event, inner only
        if (\is_a($className, \_PhpScopere8e811afab72\Nette\Application\UI\Control::class, \true)) {
            return \false;
        }
        if (\method_exists($className, $methodName)) {
            return \false;
        }
        return \property_exists($className, $methodName);
    }
}
