<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/http-request-response
 * @see https://github.com/symfony/symfony/blob/master/src/Symfony/Component/HttpFoundation/Request.php
 * @see \Rector\NetteToSymfony\Tests\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector\FromHttpRequestGetHeaderToHeadersGetRectorTest
 */
final class FromHttpRequestGetHeaderToHeadersGetRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes getHeader() to $request->headers->get()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Request;

final class SomeController
{
    public static function someAction(Request $request)
    {
        $header = $this->httpRequest->getHeader('x');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Request;

final class SomeController
{
    public static function someAction(Request $request)
    {
        $header = $request->headers->get('x');
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
        if (!$this->isObjectType($node->var, '_PhpScopere8e811afab72\\Nette\\Http\\Request')) {
            return null;
        }
        if (!$this->isName($node->name, 'getHeader')) {
            return null;
        }
        $requestName = $this->classMethodManipulator->addMethodParameterIfMissing($node, \_PhpScopere8e811afab72\Symfony\Component\HttpFoundation\Request::class, ['request', 'symfonyRequest']);
        $variable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($requestName);
        $headersPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($variable, 'headers');
        $node->var = $headersPropertyFetch;
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('get');
        return $node;
    }
}
