<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Phalcon\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 */
/**
 * @see \Rector\Phalcon\Tests\Rector\MethodCall\AddRequestToHandleMethodCallRector\AddRequestToHandleMethodCallRectorTest
 */
final class AddRequestToHandleMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add $_SERVER REQUEST_URI to method call', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run($di)
    {
        $application = new \Phalcon\Mvc\Application();
        $response = $application->handle();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run($di)
    {
        $application = new \Phalcon\Mvc\Application();
        $response = $application->handle($_SERVER["REQUEST_URI"]);
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
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Phalcon\\Mvc\\Application')) {
            return null;
        }
        if (!$this->isName($node->name, 'handle')) {
            return null;
        }
        if ($node->args === null || $node->args !== []) {
            return null;
        }
        $node->args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($this->createServerRequestUri());
        return $node;
    }
    private function createServerRequestUri() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('_SERVER'), new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('REQUEST_URI'));
    }
}
