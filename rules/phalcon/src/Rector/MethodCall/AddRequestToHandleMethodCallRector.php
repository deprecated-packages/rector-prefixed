<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Phalcon\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 */
/**
 * @see \Rector\Phalcon\Tests\Rector\MethodCall\AddRequestToHandleMethodCallRector\AddRequestToHandleMethodCallRectorTest
 */
final class AddRequestToHandleMethodCallRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add $_SERVER REQUEST_URI to method call', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper2a4e7ab1ecbc\\Phalcon\\Mvc\\Application')) {
            return null;
        }
        if (!$this->isName($node->name, 'handle')) {
            return null;
        }
        if ($node->args === null) {
            return null;
        }
        if ($node->args !== []) {
            return null;
        }
        $node->args[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($this->createServerRequestUri());
        return $node;
    }
    private function createServerRequestUri() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('_SERVER'), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_('REQUEST_URI'));
    }
}
