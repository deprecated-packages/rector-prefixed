<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * Covers https://github.com/symfony/symfony/blob/2.8/UPGRADE-2.8.md#form
 *
 * @see \Rector\Symfony3\Tests\Rector\MethodCall\StringFormTypeToClassRector\StringFormTypeToClassRectorTest
 */
final class StringFormTypeToClassRector extends \_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\AbstractFormAddRector
{
    /**
     * @var string
     */
    private const DESCRIPTION = 'Turns string Form Type references to their CONSTANT alternatives in FormTypes in Form in Symfony. To enable custom types, add link to your container XML dump in "$parameters->set(Option::SYMFONY_CONTAINER_XML_PATH_PARAMETER, ...);"';
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition(self::DESCRIPTION, [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
$formBuilder = new Symfony\Component\Form\FormBuilder;
$formBuilder->add('name', 'form.type.text');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$formBuilder = new Symfony\Component\Form\FormBuilder;
$formBuilder->add('name', \Symfony\Component\Form\Extension\Core\Type\TextType::class);
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
        if (!$this->isFormAddMethodCall($node)) {
            return null;
        }
        // not a string
        if (!$node->args[1]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var String_ $stringNode */
        $stringNode = $node->args[1]->value;
        // not a form type string
        $formClass = $this->formTypeStringToTypeProvider->matchClassForNameWithPrefix($stringNode->value);
        if ($formClass === null) {
            return null;
        }
        $node->args[1]->value = $this->createClassConstantReference($formClass);
        return $node;
    }
}
