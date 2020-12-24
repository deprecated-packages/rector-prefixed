<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://symfony.com/doc/2.8/form/form_collections.html
 * @see https://symfony.com/doc/3.0/form/form_collections.html
 * @see https://symfony2-document.readthedocs.io/en/latest/reference/forms/types/collection.html#type
 *
 * @see \Rector\Symfony3\Tests\Rector\MethodCall\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector\ChangeCollectionTypeOptionTypeFromStringToClassReferenceRectorTest
 */
final class ChangeCollectionTypeOptionTypeFromStringToClassReferenceRector extends \_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\AbstractFormAddRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change type in CollectionType from alias string to class reference', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tags', CollectionType::class, [
            'type' => 'choice',
        ]);

        $builder->add('tags', 'collection', [
            'type' => 'choice',
        ]);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tags', CollectionType::class, [
            'type' => \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
        ]);

        $builder->add('tags', 'collection', [
            'type' => \Symfony\Component\Form\Extension\Core\Type\ChoiceType::class,
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
        if (!$this->isCollectionType($node)) {
            return null;
        }
        $optionsArray = $this->matchOptionsArray($node);
        if ($optionsArray === null) {
            return null;
        }
        foreach ($optionsArray->items as $optionsArrayItem) {
            if ($optionsArrayItem === null || $optionsArrayItem->key === null) {
                continue;
            }
            if (!$this->isValues($optionsArrayItem->key, ['type', 'entry_type'])) {
                continue;
            }
            // already ::class reference
            if (!$optionsArrayItem->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
                return null;
            }
            $stringValue = $optionsArrayItem->value->value;
            $formClass = $this->formTypeStringToTypeProvider->matchClassForNameWithPrefix($stringValue);
            if ($formClass === null) {
                return null;
            }
            $optionsArrayItem->value = $this->createClassConstantReference($formClass);
        }
        return $node;
    }
}
