<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\AddNextrasDatePickerToDateControlRector\AddNextrasDatePickerToDateControlRectorTest
 */
final class AddNextrasDatePickerToDateControlRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Nextras/Form upgrade of addDatePicker method call to DateControl assign', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Form;

class SomeClass
{
    public function run()
    {
        $form = new Form();
        $form->addDatePicker('key', 'Label');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Form;

class SomeClass
{
    public function run()
    {
        $form = new Form();
        $form['key'] = new \Nextras\FormComponents\Controls\DateControl('Label');
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
        // 1. chain call
        if ($node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            if (!$this->isOnClassMethodCall($node->var, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Form', 'addDatePicker')) {
                return null;
            }
            $assign = $this->createAssign($node->var);
            if ($assign === null) {
                return null;
            }
            $controlName = $this->resolveControlName($node->var);
            $node->var = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($controlName);
            // this fixes printing indent
            $node->setAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->addNodeBeforeNode($assign, $node);
            return $node;
        }
        // 2. assign call
        if (!$this->isOnClassMethodCall($node, '_PhpScopere8e811afab72\\Nette\\Application\\UI\\Form', 'addDatePicker')) {
            return null;
        }
        return $this->createAssign($node);
    }
    private function createAssign(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $key = $methodCall->args[0]->value;
        if (!$key instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $new = $this->createDateTimeControlNew($methodCall);
        $parent = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return $new;
        }
        $arrayDimFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch($methodCall->var, $key);
        $new = $this->createDateTimeControlNew($methodCall);
        $formAssign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($arrayDimFetch, $new);
        if ($parent !== null) {
            $methodCalls = $this->betterNodeFinder->findInstanceOf($parent, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class);
            if (\count($methodCalls) > 1) {
                $controlName = $this->resolveControlName($methodCall);
                return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($controlName), $formAssign);
            }
        }
        return $formAssign;
    }
    private function resolveControlName(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $controlName = $methodCall->args[0]->value;
        if (!$controlName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $controlName->value . 'DateControl';
    }
    private function createDateTimeControlNew(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_
    {
        $fullyQualified = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Nextras\\FormComponents\\Controls\\DateControl');
        $new = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_($fullyQualified);
        if (isset($methodCall->args[1])) {
            $new->args[] = $methodCall->args[1];
        }
        return $new;
    }
}
