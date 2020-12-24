<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Laravel\Rector\New_;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/commit/f5d8c0a673aa9fc6cd94aa4858a0027fe550a22e#diff-162a49c054acde9f386ec735607b95bc4a1c0c765a6f46da8de9a8a4ef5199d3
 * @see https://github.com/laravel/framework/pull/25261
 *
 * @see \Rector\Laravel\Tests\Rector\New_\AddGuardToLoginEventRector\AddGuardToLoginEventRectorTest
 */
final class AddGuardToLoginEventRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoper2a4e7ab1ecbc\\Add new $guard argument to Illuminate\\Auth\\Events\\Login', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Illuminate\Auth\Events\Login;

final class SomeClass
{
    public function run(): void
    {
        $loginEvent = new Login('user', false);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Illuminate\Auth\Events\Login;

final class SomeClass
{
    public function run(): void
    {
        $guard = config('auth.defaults.guard');
        $loginEvent = new Login($guard, 'user', false);
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isName($node->class, '_PhpScoper2a4e7ab1ecbc\\Illuminate\\Auth\\Events\\Login')) {
            return null;
        }
        if (\count((array) $node->args) === 3) {
            return null;
        }
        $guardVariable = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable('guard');
        $assign = $this->createGuardAssign($guardVariable);
        $this->addNodeBeforeNode($assign, $node);
        $node->args = \array_merge([new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($guardVariable)], (array) $node->args);
        return $node;
    }
    private function createGuardAssign(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $guardVariable) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign
    {
        $string = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_('auth.defaults.guard');
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign($guardVariable, $this->createFuncCall('config', [$string]));
    }
}
