<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Nette\Tests\Rector\MethodCall\AddNextrasDatePickerToDateControlRector\AddNextrasDatePickerToDateControlRectorTest
 */
final class AddNextrasDatePickerToDateControlRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Nextras/Form upgrade of addDatePicker method call to DateControl assign', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // 1. chain call
        if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            if (!$this->isOnClassMethodCall($node->var, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Form', 'addDatePicker')) {
                return null;
            }
            $assign = $this->createAssign($node->var);
            if ($assign === null) {
                return null;
            }
            $controlName = $this->resolveControlName($node->var);
            $node->var = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($controlName);
            // this fixes printing indent
            $node->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE, null);
            $this->addNodeBeforeNode($assign, $node);
            return $node;
        }
        // 2. assign call
        if (!$this->isOnClassMethodCall($node, '_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Form', 'addDatePicker')) {
            return null;
        }
        return $this->createAssign($node);
    }
    private function createAssign(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $key = $methodCall->args[0]->value;
        if (!$key instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            return null;
        }
        $new = $this->createDateTimeControlNew($methodCall);
        $parent = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return $new;
        }
        $arrayDimFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch($methodCall->var, $key);
        $new = $this->createDateTimeControlNew($methodCall);
        $formAssign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($arrayDimFetch, $new);
        if ($parent !== null) {
            $methodCalls = $this->betterNodeFinder->findInstanceOf($parent, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall::class);
            if (\count($methodCalls) > 1) {
                $controlName = $this->resolveControlName($methodCall);
                return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($controlName), $formAssign);
            }
        }
        return $formAssign;
    }
    private function resolveControlName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $controlName = $methodCall->args[0]->value;
        if (!$controlName instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $controlName->value . 'DateControl';
    }
    private function createDateTimeControlNew(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_
    {
        $fullyQualified = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Nextras\\FormComponents\\Controls\\DateControl');
        $new = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_($fullyQualified);
        if (isset($methodCall->args[1])) {
            $new->args[] = $methodCall->args[1];
        }
        return $new;
    }
}
