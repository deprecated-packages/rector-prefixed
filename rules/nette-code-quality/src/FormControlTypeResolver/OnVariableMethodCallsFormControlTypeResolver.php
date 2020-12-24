<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\FormControlTypeResolver;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\ValueObject\NetteFormMethodNameToControlType;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
final class OnVariableMethodCallsFormControlTypeResolver implements \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Contract\FormControlTypeResolverInterface
{
    /**
     * @var MethodCallManipulator
     */
    private $methodCallManipulator;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator $methodCallManipulator, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->methodCallManipulator = $methodCallManipulator;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
    }
    /**
     * @return array<string, string>
     */
    public function resolve(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return [];
        }
        $onFormMethodCalls = $this->methodCallManipulator->findMethodCallsOnVariable($node);
        $methodNamesByInputNames = [];
        foreach ($onFormMethodCalls as $onFormMethodCall) {
            $methodName = $this->nodeNameResolver->getName($onFormMethodCall->name);
            if ($methodName === null) {
                continue;
            }
            if (!isset(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\ValueObject\NetteFormMethodNameToControlType::METHOD_NAME_TO_CONTROL_TYPE[$methodName])) {
                continue;
            }
            if (!isset($onFormMethodCall->args[0])) {
                continue;
            }
            $addedInputName = $this->valueResolver->getValue($onFormMethodCall->args[0]->value);
            if (!\is_string($addedInputName)) {
                throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
            }
            $methodNamesByInputNames[$addedInputName] = $methodName;
        }
        return $methodNamesByInputNames;
    }
}
