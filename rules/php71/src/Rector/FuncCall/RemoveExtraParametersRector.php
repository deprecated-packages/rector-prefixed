<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php71\Rector\FuncCall;

use function count;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\Type\UnionTypeMethodReflection;
use _PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\CallReflectionResolver;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://www.reddit.com/r/PHP/comments/a1ie7g/is_there_a_linter_for_argumentcounterror_for_php/
 * @see http://php.net/manual/en/class.argumentcounterror.php
 *
 * @see \Rector\Php71\Tests\Rector\FuncCall\RemoveExtraParametersRector\RemoveExtraParametersRectorTest
 */
final class RemoveExtraParametersRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CallReflectionResolver
     */
    private $callReflectionResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PHPStan\Reflection\CallReflectionResolver $callReflectionResolver)
    {
        $this->callReflectionResolver = $callReflectionResolver;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove extra parameters', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('strlen("asdf", 1);', 'strlen("asdf");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        // unreliable count of arguments
        $functionLikeReflection = $this->callReflectionResolver->resolveCall($node);
        if ($functionLikeReflection instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Type\UnionTypeMethodReflection) {
            return null;
        }
        /** @var ParametersAcceptor $parametersAcceptor */
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($functionLikeReflection, $node);
        $numberOfParameters = \count($parametersAcceptor->getParameters());
        $numberOfArguments = \count((array) $node->args);
        for ($i = $numberOfParameters; $i <= $numberOfArguments; ++$i) {
            unset($node->args[$i]);
        }
        return $node;
    }
    /**
     * @param FuncCall|MethodCall|StaticCall $node
     */
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if ($node->args === []) {
            return \true;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            if (!$node->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                return \true;
            }
            if ($this->isName($node->class, 'parent')) {
                return \true;
            }
        }
        $parametersAcceptor = $this->callReflectionResolver->resolveParametersAcceptor($this->callReflectionResolver->resolveCall($node), $node);
        if ($parametersAcceptor === null) {
            return \true;
        }
        // can be any number of arguments → nothing to limit here
        if ($parametersAcceptor->isVariadic()) {
            return \true;
        }
        return \count($parametersAcceptor->getParameters()) >= \count($node->args);
    }
}
