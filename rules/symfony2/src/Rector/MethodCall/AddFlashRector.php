<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony2\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symfony\Bundle\FrameworkBundle\Controller\Controller;
use _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony2\Tests\Rector\MethodCall\AddFlashRector\AddFlashRectorTest
 */
final class AddFlashRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer)
    {
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns long flash adding to short helper method in Controller in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController extends Controller
{
    public function some(Request $request)
    {
        $request->getSession()->getFlashBag()->add("success", "something");
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController extends Controller
{
    public function some(Request $request)
    {
        $this->addFlash("success", "something");
    }
}
CODE_SAMPLE
)]);
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
        if (!$this->fluentChainMethodCallNodeAnalyzer->isTypeAndChainCalls($node, new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType(\_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request::class), ['getSession', 'getFlashBag', 'add'])) {
            return null;
        }
        return $this->createMethodCall('this', 'addFlash', $node->args);
    }
}
