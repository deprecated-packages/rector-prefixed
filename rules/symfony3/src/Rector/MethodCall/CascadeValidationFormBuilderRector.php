<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\Rector\MethodCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ArrayManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://gist.github.com/mickaelandrieu/5d27a2ffafcbdd64912f549aaf2a6df9#stuck-with-forms
 * @see \Rector\Symfony3\Tests\Rector\MethodCall\CascadeValidationFormBuilderRector\CascadeValidationFormBuilderRectorTest
 */
final class CascadeValidationFormBuilderRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ArrayManipulator
     */
    private $arrayManipulator;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\ArrayManipulator $arrayManipulator)
    {
        $this->arrayManipulator = $arrayManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change "cascade_validation" option to specific node attribute', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeController
{
    public function someMethod()
    {
        $form = $this->createFormBuilder($article, ['cascade_validation' => true])
            ->add('author', new AuthorType())
            ->getForm();
    }

    protected function createFormBuilder()
    {
        return new FormBuilder();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeController
{
    public function someMethod()
    {
        $form = $this->createFormBuilder($article)
            ->add('author', new AuthorType(), [
                'constraints' => new \Symfony\Component\Validator\Constraints\Valid(),
            ])
            ->getForm();
    }

    protected function createFormBuilder()
    {
        return new FormBuilder();
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
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var Array_ $formBuilderOptionsArrayNode */
        $formBuilderOptionsArrayNode = $node->args[1]->value;
        if (!$this->isSuccessfulRemovalCascadeValidationOption($node, $formBuilderOptionsArrayNode)) {
            return null;
        }
        $this->addConstraintsOptionToFollowingAddMethodCalls($node);
        return $node;
    }
    private function shouldSkip(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->isName($methodCall->name, 'createFormBuilder')) {
            return \true;
        }
        if (!isset($methodCall->args[1])) {
            return \true;
        }
        return !$methodCall->args[1]->value instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
    }
    private function isSuccessfulRemovalCascadeValidationOption(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_ $optionsArrayNode) : bool
    {
        foreach ($optionsArrayNode->items as $key => $arrayItem) {
            if ($arrayItem === null) {
                continue;
            }
            if (!$this->arrayManipulator->hasKeyName($arrayItem, 'cascade_validation')) {
                continue;
            }
            if (!$this->isTrue($arrayItem->value)) {
                continue;
            }
            unset($optionsArrayNode->items[$key]);
            // remove empty array
            if ($optionsArrayNode->items === []) {
                unset($methodCall->args[1]);
            }
            return \true;
        }
        return \false;
    }
    private function addConstraintsOptionToFollowingAddMethodCalls(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        $new = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Symfony\\Component\\Validator\\Constraints\\Valid'));
        $constraintsArrayItem = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($new, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_('constraints'));
        $parentNode = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall) {
            if ($this->isName($parentNode->name, 'add')) {
                /** @var Array_ $addOptionsArrayNode */
                $addOptionsArrayNode = isset($parentNode->args[2]) ? $parentNode->args[2]->value : new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
                $addOptionsArrayNode->items[] = $constraintsArrayItem;
                $parentNode->args[2] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($addOptionsArrayNode);
            }
            $parentNode = $parentNode->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
    }
}
