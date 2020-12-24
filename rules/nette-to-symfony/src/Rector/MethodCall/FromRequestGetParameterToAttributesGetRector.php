<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony\Rector\MethodCall;

use _PhpScopere8e811afab72\Nette\Application\Request;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/http-request-response
 * @see https://github.com/symfony/symfony/blob/master/src/Symfony/Component/HttpFoundation/Request.php
 * @see \Rector\NetteToSymfony\Tests\Rector\MethodCall\FromRequestGetParameterToAttributesGetRector\FromRequestGetParameterToAttributesGetRectorTest
 */
final class FromRequestGetParameterToAttributesGetRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes "getParameter()" to "attributes->get()" from Nette to Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Request;

final class SomeController
{
    public static function someAction(Request $request)
    {
        $value = $request->getParameter('abz');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Request;

final class SomeController
{
    public static function someAction(Request $request)
    {
        $value = $request->attribute->get('abz');
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
        if (!$this->isObjectType($node, '_PhpScopere8e811afab72\\Nette\\Application\\Request')) {
            return null;
        }
        if (!$this->isName($node->name, 'getParameter')) {
            return null;
        }
        $requestAttributesPropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch($node->var, 'attributes');
        $node->var = $requestAttributesPropertyFetch;
        $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('get');
        return $node;
    }
}
