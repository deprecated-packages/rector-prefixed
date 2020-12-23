<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Phalcon\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/rectorphp/rector/issues/2408
 */
/**
 * @see \Rector\Phalcon\Tests\Rector\MethodCall\AddRequestToHandleMethodCallRector\AddRequestToHandleMethodCallRectorTest
 */
final class AddRequestToHandleMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add $_SERVER REQUEST_URI to method call', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper0a2ac50786fa\\Phalcon\\Mvc\\Application')) {
            return null;
        }
        if (!$this->isName($node->name, 'handle')) {
            return null;
        }
        if ($node->args === null || $node->args !== []) {
            return null;
        }
        $node->args[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($this->createServerRequestUri());
        return $node;
    }
    private function createServerRequestUri() : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch
    {
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable('_SERVER'), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('REQUEST_URI'));
    }
}
