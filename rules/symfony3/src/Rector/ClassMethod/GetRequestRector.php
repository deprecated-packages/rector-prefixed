<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Symfony\Bridge\NodeAnalyzer\ControllerMethodAnalyzer;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony3\Tests\Rector\ClassMethod\GetRequestRector\GetRequestRectorTest
 */
final class GetRequestRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const REQUEST_CLASS = '_PhpScopere8e811afab72\\Symfony\\Component\\HttpFoundation\\Request';
    /**
     * @var string
     */
    private $requestVariableAndParamName;
    /**
     * @var ControllerMethodAnalyzer
     */
    private $controllerMethodAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Symfony\Bridge\NodeAnalyzer\ControllerMethodAnalyzer $controllerMethodAnalyzer)
    {
        $this->controllerMethodAnalyzer = $controllerMethodAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns fetching of dependencies via `$this->get()` to constructor injection in Command and Controller in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function someAction()
    {
        $this->getRequest()->...();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\HttpFoundation\Request;

class SomeController
{
    public function someAction(Request $request)
    {
        $request->...();
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param ClassMethod|MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $this->requestVariableAndParamName = $this->resolveUniqueName($node, 'request');
            if ($this->isActionWithGetRequestInBody($node)) {
                $fullyQualified = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(self::REQUEST_CLASS);
                $node->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($this->requestVariableAndParamName), null, $fullyQualified);
                return $node;
            }
        }
        if ($this->isGetRequestInAction($node)) {
            return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($this->requestVariableAndParamName);
        }
        return null;
    }
    private function resolveUniqueName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, string $name) : string
    {
        $candidateNames = [];
        foreach ($classMethod->params as $param) {
            $candidateNames[] = $this->getName($param);
        }
        $bareName = $name;
        $prefixes = ['main', 'default'];
        while (\in_array($name, $candidateNames, \true)) {
            $name = \array_shift($prefixes) . \ucfirst($bareName);
        }
        return $name;
    }
    private function isActionWithGetRequestInBody(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->controllerMethodAnalyzer->isAction($classMethod)) {
            return \false;
        }
        $containsGetRequestMethod = $this->containsGetRequestMethod($classMethod);
        if ($containsGetRequestMethod) {
            return \true;
        }
        /** @var MethodCall[] $getMethodCalls */
        $getMethodCalls = $this->betterNodeFinder->find($classMethod, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return $this->isLocalMethodCallNamed($node, 'get');
        });
        foreach ($getMethodCalls as $getMethodCall) {
            if ($this->isGetMethodCallWithRequestParameters($getMethodCall)) {
                return \true;
            }
        }
        return \false;
    }
    private function isGetRequestInAction(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        // must be $this->getRequest() in controller
        if (!$this->isVariableName($node->var, 'this')) {
            return \false;
        }
        if (!$this->isName($node->name, 'getRequest') && !$this->isGetMethodCallWithRequestParameters($node)) {
            return \false;
        }
        $classMethod = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return \false;
        }
        return $this->controllerMethodAnalyzer->isAction($classMethod);
    }
    private function containsGetRequestMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : bool {
            return $this->isLocalMethodCallNamed($node, 'getRequest');
        });
    }
    private function isGetMethodCallWithRequestParameters(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isName($methodCall->name, 'get')) {
            return \false;
        }
        if (\count((array) $methodCall->args) !== 1) {
            return \false;
        }
        if (!$methodCall->args[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return \false;
        }
        /** @var String_ $stringValue */
        $stringValue = $methodCall->args[0]->value;
        return $stringValue->value === 'request';
    }
}
