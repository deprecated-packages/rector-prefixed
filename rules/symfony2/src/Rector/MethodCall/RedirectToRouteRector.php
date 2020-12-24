<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony2\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symfony\Bundle\FrameworkBundle\Controller\Controller;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\MethodCall\RedirectToRouteRector\RedirectToRouteRectorTest
 */
final class RedirectToRouteRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns redirect to route to short helper method in Controller in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->redirect($this->generateUrl("homepage"));', '$this->redirectToRoute("homepage");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $parentClassName = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScopere8e811afab72\Symfony\Bundle\FrameworkBundle\Controller\Controller::class) {
            return null;
        }
        if (!$this->isName($node->name, 'redirect')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $argumentValue = $node->args[0]->value;
        if (!$argumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!$this->isName($argumentValue->name, 'generateUrl')) {
            return null;
        }
        return $this->createMethodCall('this', 'redirectToRoute', $this->resolveArguments($node));
    }
    /**
     * @return mixed[]
     */
    private function resolveArguments(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        /** @var MethodCall $generateUrlNode */
        $generateUrlNode = $methodCall->args[0]->value;
        $arguments = [];
        $arguments[] = $generateUrlNode->args[0];
        if (isset($generateUrlNode->args[1])) {
            $arguments[] = $generateUrlNode->args[1];
        }
        if (!isset($generateUrlNode->args[1]) && isset($methodCall->args[1])) {
            $arguments[] = [];
        }
        if (isset($methodCall->args[1])) {
            $arguments[] = $methodCall->args[1];
        }
        return $arguments;
    }
}
