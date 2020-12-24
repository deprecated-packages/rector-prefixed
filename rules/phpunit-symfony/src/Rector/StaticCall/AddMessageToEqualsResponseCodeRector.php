<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnitSymfony\Rector\StaticCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\PHPUnitSymfony\Tests\Rector\StaticCall\AddMessageToEqualsResponseCodeRector\AddMessageToEqualsResponseCodeRectorTest
 */
final class AddMessageToEqualsResponseCodeRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add response content to response code assert, so it is easier to debug', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class SomeClassTest extends TestCase
{
    public function test(Response $response)
    {
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode()
        );
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

final class SomeClassTest extends TestCase
{
    public function test(Response $response)
    {
        $this->assertEquals(
            Response::HTTP_NO_CONTENT,
            $response->getStatusCode()
            $response->getContent()
        );
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param StaticCall|MethodCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node->name, 'assertEquals')) {
            return null;
        }
        // already has 3rd "message" argument
        if (isset($node->args[2])) {
            return null;
        }
        if (!$this->isHttpRequestArgument($node->args[0]->value)) {
            return null;
        }
        $parentVariable = $this->getParentOfGetStatusCode($node->args[1]->value);
        if ($parentVariable === null) {
            return null;
        }
        $getContentMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($parentVariable, 'getContent');
        $node->args[2] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($getContentMethodCall);
        return $node;
    }
    /**
     * $this->assertX(Response::SOME_STATUS)
     */
    private function isHttpRequestArgument(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : bool
    {
        if (!$expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ClassConstFetch) {
            return \false;
        }
        return $this->isObjectType($expr->class, '_PhpScoper0a6b37af0871\\Symfony\\Component\\HttpFoundation\\Response');
    }
    /**
     * @return Variable|MethodCall|Expr|null
     */
    private function getParentOfGetStatusCode(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr $expr) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $currentNode = $expr;
        while ($currentNode instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            if ($this->isName($currentNode->name, 'getStatusCode')) {
                return $currentNode->var;
            }
            $currentNode = $currentNode->var;
        }
        return null;
    }
}
