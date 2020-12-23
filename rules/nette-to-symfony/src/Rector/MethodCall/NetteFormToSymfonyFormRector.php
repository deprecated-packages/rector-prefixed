<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteToSymfony\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/forms
 * ↓
 * @see https://symfony.com/doc/current/forms.html
 *
 * @see https://github.com/nette/forms/blob/master/src/Forms/Container.php
 * ↓
 * @see https://github.com/symfony/symfony/tree/master/src/Symfony/Component/Form/Extension/Core/Type
 * @see \Rector\NetteToSymfony\Tests\Rector\MethodCall\NetteFormToSymfonyFormRector\NetteFormToSymfonyFormRectorTest
 */
final class NetteFormToSymfonyFormRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private const ADD_METHOD_TO_FORM_TYPE = [
        'addText' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextType',
        'addPassword' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\PasswordType',
        'addTextArea' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\TextareaType',
        'addEmail' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\EmailType',
        'addInteger' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\IntegerType',
        'addHidden' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\HiddenType',
        // https://symfony.com/doc/current/reference/forms/types/checkbox.html
        'addCheckbox' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\CheckboxType',
        'addUpload' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType',
        'addImage' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType',
        'addMultiUpload' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\FileType',
        // https://symfony.com/doc/current/reference/forms/types/choice.html#select-tag-checkboxes-or-radio-buttons
        'addSelect' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType',
        'addRadioList' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType',
        'addCheckboxList' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType',
        'addMultiSelect' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ChoiceType',
        'addSubmit' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\SubmitType',
        'addButton' => '_PhpScoper0a2ac50786fa\\Symfony\\Component\\Form\\Extension\\Core\\Type\\ButtonType',
    ];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate Nette\\Forms in Presenter to Symfony', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI;

class SomePresenter extends UI\Presenter
{
    public function someAction()
    {
        $form = new UI\Form;
        $form->addText('name', 'Name:');
        $form->addPassword('password', 'Password:');
        $form->addSubmit('login', 'Sign up');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI;

class SomePresenter extends UI\Presenter
{
    public function someAction()
    {
        $form = $this->createFormBuilder();
        $form->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class, [
            'label' => 'Name:'
        ]);
        $form->add('password', \Symfony\Component\Form\Extension\Core\Type\PasswordType::class, [
            'label' => 'Password:'
        ]);
        $form->add('login', \Symfony\Component\Form\Extension\Core\Type\SubmitType::class, [
            'label' => 'Sign up'
        ]);
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param New_|MethodCall $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        if (!$this->isObjectType($classLike, '_PhpScoper0a2ac50786fa\\Nette\\Application\\IPresenter')) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
            return $this->processNew($node);
        }
        /** @var MethodCall $node */
        if (!$this->isObjectType($node->var, '_PhpScoper0a2ac50786fa\\Nette\\Application\\UI\\Form')) {
            return null;
        }
        foreach (self::ADD_METHOD_TO_FORM_TYPE as $method => $classType) {
            if (!$this->isName($node->name, $method)) {
                continue;
            }
            $this->processAddMethod($node, $method, $classType);
        }
        return $node;
    }
    private function processNew(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_ $new) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        if (!$this->isName($new->class, '_PhpScoper0a2ac50786fa\\Nette\\Application\\UI\\Form')) {
            return null;
        }
        return $this->createMethodCall('this', 'createFormBuilder');
    }
    private function processAddMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall, string $method, string $classType) : void
    {
        $methodCall->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('add');
        // remove unused params
        if ($method === 'addText') {
            unset($methodCall->args[3], $methodCall->args[4]);
        }
        // has label
        $optionsArray = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_();
        if (isset($methodCall->args[1])) {
            $optionsArray->items[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($methodCall->args[1]->value, new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('label'));
        }
        $this->addChoiceTypeOptions($method, $optionsArray);
        $this->addMultiFileTypeOptions($method, $optionsArray);
        $methodCall->args[1] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($this->createClassConstantReference($classType));
        if ($optionsArray->items !== []) {
            $methodCall->args[2] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($optionsArray);
        }
    }
    private function addChoiceTypeOptions(string $method, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $optionsArray) : void
    {
        if ($method === 'addSelect') {
            $expanded = \false;
            $multiple = \false;
        } elseif ($method === 'addRadioList') {
            $expanded = \true;
            $multiple = \false;
        } elseif ($method === 'addCheckboxList') {
            $expanded = \true;
            $multiple = \true;
        } elseif ($method === 'addMultiSelect') {
            $expanded = \false;
            $multiple = \true;
        } else {
            return;
        }
        $optionsArray->items[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($expanded ? $this->createTrue() : $this->createFalse(), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('expanded'));
        $optionsArray->items[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($multiple ? $this->createTrue() : $this->createFalse(), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('multiple'));
    }
    private function addMultiFileTypeOptions(string $method, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Array_ $optionsArray) : void
    {
        if ($method !== 'addMultiUpload') {
            return;
        }
        $optionsArray->items[] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayItem($this->createTrue(), new \_PhpScoper0a2ac50786fa\PhpParser\Node\Scalar\String_('multiple'));
    }
}
