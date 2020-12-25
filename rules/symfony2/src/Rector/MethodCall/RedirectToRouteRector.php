<?php

declare (strict_types=1);
namespace Rector\Symfony2\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper8b9c402c5f32\Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\MethodCall\RedirectToRouteRector\RedirectToRouteRectorTest
 */
final class RedirectToRouteRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns redirect to route to short helper method in Controller in Symfony', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample('$this->redirect($this->generateUrl("homepage"));', '$this->redirectToRoute("homepage");')]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $parentClassName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        if ($parentClassName !== \_PhpScoper8b9c402c5f32\Symfony\Bundle\FrameworkBundle\Controller\Controller::class) {
            return null;
        }
        if (!$this->isName($node->name, 'redirect')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        $argumentValue = $node->args[0]->value;
        if (!$argumentValue instanceof \PhpParser\Node\Expr\MethodCall) {
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
    private function resolveArguments(\PhpParser\Node\Expr\MethodCall $methodCall) : array
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
