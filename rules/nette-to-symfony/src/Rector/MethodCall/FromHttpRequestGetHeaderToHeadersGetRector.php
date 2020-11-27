<?php

declare (strict_types=1);
namespace Rector\NetteToSymfony\Rector\MethodCall;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator;
use Rector\Core\Rector\AbstractRector;
use _PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/http-request-response
 * @see https://github.com/symfony/symfony/blob/master/src/Symfony/Component/HttpFoundation/Request.php
 * @see \Rector\NetteToSymfony\Tests\Rector\MethodCall\FromHttpRequestGetHeaderToHeadersGetRector\FromHttpRequestGetHeaderToHeadersGetRectorTest
 */
final class FromHttpRequestGetHeaderToHeadersGetRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassMethodManipulator
     */
    private $classMethodManipulator;
    public function __construct(\Rector\Core\PhpParser\Node\Manipulator\ClassMethodManipulator $classMethodManipulator)
    {
        $this->classMethodManipulator = $classMethodManipulator;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes getHeader() to $request->headers->get()', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoper006a73f0e455\\Nette\\Http\\Request')) {
            return null;
        }
        if (!$this->isName($node->name, 'getHeader')) {
            return null;
        }
        $requestName = $this->classMethodManipulator->addMethodParameterIfMissing($node, \_PhpScoper006a73f0e455\Symfony\Component\HttpFoundation\Request::class, ['request', 'symfonyRequest']);
        $variable = new \PhpParser\Node\Expr\Variable($requestName);
        $headersPropertyFetch = new \PhpParser\Node\Expr\PropertyFetch($variable, 'headers');
        $node->var = $headersPropertyFetch;
        $node->name = new \PhpParser\Node\Identifier('get');
        return $node;
    }
}
