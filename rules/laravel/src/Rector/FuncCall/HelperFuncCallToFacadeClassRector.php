<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Laravel\Rector\FuncCall;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://laravel.com/docs/8.x/helpers#method-app
 * @see https://github.com/laravel/framework/blob/8.x/src/Illuminate/Foundation/helpers.php
 *
 * @see \Rector\Laravel\Tests\Rector\FuncCall\HelperFuncCallToFacadeClassRector\HelperFuncCallToFacadeClassRectorTest
 */
final class HelperFuncCallToFacadeClassRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change app() func calls to facade calls', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return app('translator')->trans('value');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return \Illuminate\Support\Facades\App::get('translator')->trans('value');
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall::class];
    }
    /**
     * @param FuncCall $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isName($node->name, 'app')) {
            return null;
        }
        if (\count((array) $node->args) !== 1) {
            return null;
        }
        return $this->createStaticCall('_PhpScoper0a6b37af0871\\Illuminate\\Support\\Facades\\App', 'get', (array) $node->args);
    }
}
