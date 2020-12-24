<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\RequestGetCookieDefaultArgumentToCoalesceRector\RequestGetCookieDefaultArgumentToCoalesceRectorTest
 */
final class RequestGetCookieDefaultArgumentToCoalesceRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add removed Nette\\Http\\Request::getCookies() default value as coalesce', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Http\Request;

class SomeClass
{
    public function run(Request $request)
    {
        return $request->getCookie('name', 'default');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Http\Request;

class SomeClass
{
    public function run(Request $request)
    {
        return $request->getCookie('name') ?? 'default';
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectType($node->var, '_PhpScoperb75b35f52b74\\Nette\\Http\\Request')) {
            return null;
        }
        if (!$this->isName($node->name, 'getCookie')) {
            return null;
        }
        // no default value
        if (!isset($node->args[1])) {
            return null;
        }
        $defaultValue = $node->args[1]->value;
        unset($node->args[1]);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\BinaryOp\Coalesce($node, $defaultValue);
    }
}
