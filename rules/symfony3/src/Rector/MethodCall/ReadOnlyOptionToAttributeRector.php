<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ArrayManipulator;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony3\Tests\Rector\MethodCall\ReadOnlyOptionToAttributeRector\ReadOnlyOptionToAttributeRectorTest
 */
final class ReadOnlyOptionToAttributeRector extends \_PhpScopere8e811afab72\Rector\Symfony3\Rector\MethodCall\AbstractFormAddRector
{
    /**
     * @var ArrayManipulator
     */
    private $arrayManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ArrayManipulator $arrayManipulator)
    {
        $this->arrayManipulator = $arrayManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change "read_only" option in form to attribute', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Component\Form\FormBuilderInterface;

function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder->add('cuid', TextType::class, ['read_only' => true]);
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Component\Form\FormBuilderInterface;

function buildForm(FormBuilderInterface $builder, array $options)
{
    $builder->add('cuid', TextType::class, ['attr' => ['read_only' => true]]);
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
        $optionsArray = $this->matchOptionsArray($node);
        if ($optionsArray === null) {
            return null;
        }
        if (!$optionsArray instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
            return null;
        }
        $readOnlyArrayItem = $this->arrayManipulator->findItemInInArrayByKeyAndUnset($optionsArray, 'read_only');
        if ($readOnlyArrayItem === null) {
            return null;
        }
        // rename string
        $readOnlyArrayItem->key = new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('readonly');
        $this->arrayManipulator->addItemToArrayUnderKey($optionsArray, $readOnlyArrayItem, 'attr');
        return $node;
    }
}
