<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Laravel\Rector\New_;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/laravel/framework/commit/f5d8c0a673aa9fc6cd94aa4858a0027fe550a22e#diff-162a49c054acde9f386ec735607b95bc4a1c0c765a6f46da8de9a8a4ef5199d3
 * @see https://github.com/laravel/framework/pull/25261
 *
 * @see \Rector\Laravel\Tests\Rector\New_\AddGuardToLoginEventRector\AddGuardToLoginEventRectorTest
 */
final class AddGuardToLoginEventRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('_PhpScoperb75b35f52b74\\Add new $guard argument to Illuminate\\Auth\\Events\\Login', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_::class];
    }
    /**
     * @param New_ $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if (!$this->isName($node->class, '_PhpScoperb75b35f52b74\\Illuminate\\Auth\\Events\\Login')) {
            return null;
        }
        if (\count((array) $node->args) === 3) {
            return null;
        }
        $guardVariable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('guard');
        $assign = $this->createGuardAssign($guardVariable);
        $this->addNodeBeforeNode($assign, $node);
        $node->args = \array_merge([new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($guardVariable)], (array) $node->args);
        return $node;
    }
    private function createGuardAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $guardVariable) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign
    {
        $string = new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('auth.defaults.guard');
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($guardVariable, $this->createFuncCall('config', [$string]));
    }
}
