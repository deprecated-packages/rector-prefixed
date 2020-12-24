<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\Assign;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\Assign\ArrayAccessSetControlToAddComponentMethodCallRector\ArrayAccessSetControlToAddComponentMethodCallRectorTest
 *
 * @see https://github.com/nette/component-model/blob/c1fb11729423379768a71dd865ae373a3b12fa43/src/ComponentModel/Container.php#L39
 */
final class ArrayAccessSetControlToAddComponentMethodCallRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change magic arrays access set, to explicit $this->setComponent(...) method', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function some()
    {
        $someControl = new Control();
        $this['whatever'] = $someControl;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Control;
use Nette\Application\UI\Presenter;

class SomeClass extends Presenter
{
    public function some()
    {
        $someControl = new Control();
        $this->addComponent($someControl, 'whatever');
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign::class];
    }
    /**
     * @param Assign $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isAssignOfControlToPresenterDimFetch($node)) {
            return null;
        }
        /** @var ArrayDimFetch $arrayDimFetch */
        $arrayDimFetch = $node->var;
        $arguments = [$node->expr, $arrayDimFetch->dim];
        $arg = $this->createArgs($arguments);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($arrayDimFetch->var, 'addComponent', $arg);
    }
    private function isAssignOfControlToPresenterDimFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign $assign) : bool
    {
        if (!$assign->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch) {
            return \false;
        }
        if (!$this->isObjectType($assign->expr, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Control')) {
            return \false;
        }
        $arrayDimFetch = $assign->var;
        if (!$arrayDimFetch->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->isObjectType($arrayDimFetch->var, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Presenter');
    }
}
