<?php

declare (strict_types=1);
namespace Rector\Laravel\Rector\StaticCall;

use PhpParser\Node;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PHPStan\Type\ObjectType;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/5.7/upgrade
 * @see \Rector\Laravel\Tests\Rector\StaticCall\Redirect301ToPermanentRedirectRector\Redirect301ToPermanentRedirectRectorTest
 */
final class Redirect301ToPermanentRedirectRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $routerObjectTypes = [];
    public function __construct()
    {
        $this->routerObjectTypes = [new \PHPStan\Type\ObjectType('Illuminate\\Support\\Facades\\Route'), new \PHPStan\Type\ObjectType('Illuminate\\Routing\\Route')];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change "redirect" call with 301 to "permanentRedirect"', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->nodeTypeResolver->isObjectTypes($node->class, $this->routerObjectTypes)) {
            return null;
        }
        if (!isset($node->args[2])) {
            return null;
        }
        $is301 = $this->valueResolver->isValue($node->args[2]->value, 301);
        if (!$is301) {
            return null;
        }
        unset($node->args[2]);
        $node->name = new \PhpParser\Node\Identifier('permanentRedirect');
        return $node;
    }
}
