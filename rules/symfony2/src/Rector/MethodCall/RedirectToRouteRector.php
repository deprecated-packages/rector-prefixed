<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Symfony2\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symfony\Bundle\FrameworkBundle\Controller\Controller;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\MethodCall\RedirectToRouteRector\RedirectToRouteRectorTest
 */
final class RedirectToRouteRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns redirect to route to short helper method in Controller in Symfony', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->redirect($this->generateUrl("homepage"));', '$this->redirectToRoute("homepage");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $parentClassName = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScoper0a2ac50786fa\Symfony\Bundle\FrameworkBundle\Controller\Controller::class) {
            return null;
        }
        if (!$this->isName($node->name, 'redirect')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $argumentValue = $node->args[0]->value;
        if (!$argumentValue instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
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
    private function resolveArguments(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : array
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
