<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.7/upgrade
 * @see \Rector\Laravel\Tests\Rector\StaticCall\Redirect301ToPermanentRedirectRector\Redirect301ToPermanentRedirectRectorTest
 */
final class Redirect301ToPermanentRedirectRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const ROUTE_TYPES = ['_PhpScoperb75b35f52b74\\Illuminate\\Support\\Facades\\Route', '_PhpScoperb75b35f52b74\\Illuminate\\Routing\\Route'];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change "redirect" call with 301 to "permanentRedirect"', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        Illuminate\Routing\Route::redirect('/foo', '/bar', 301);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        Illuminate\Routing\Route::permanentRedirect('/foo', '/bar');
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isObjectTypes($node, self::ROUTE_TYPES)) {
            return null;
        }
        if (!isset($node->args[2])) {
            return null;
        }
        if ($this->getValue($node->args[2]->value) !== 301) {
            return null;
        }
        unset($node->args[2]);
        $node->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('permanentRedirect');
        return $node;
    }
}
