<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony4\Rector\MethodCall;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Symfony4\Tests\Rector\MethodCall\FormIsValidRector\FormIsValidRectorTest
 */
final class FormIsValidRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodCallManipulator
     */
    private $methodCallManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\MethodCallManipulator $methodCallManipulator)
    {
        $this->methodCallManipulator = $methodCallManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds `$form->isSubmitted()` validation to all `$form->isValid()` calls in Form in Symfony', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
if ($form->isValid()) {
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
if ($form->isSubmitted() && $form->isValid()) {
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
        if ($this->shouldSkipMethodCall($node)) {
            return null;
        }
        /** @var Variable $variable */
        $variable = $node->var;
        if ($this->isIsSubmittedByAlreadyCalledOnVariable($variable)) {
            return null;
        }
        /** @var string $variableName */
        $variableName = $this->getName($node->var);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\BinaryOp\BooleanAnd($this->createMethodCall($variableName, 'isSubmitted'), $this->createMethodCall($variableName, 'isValid'));
    }
    private function shouldSkipMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        $originalNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::ORIGINAL_NODE);
        // skip just added calls
        if ($originalNode === null) {
            return \true;
        }
        if (!$this->isObjectType($methodCall->var, '_PhpScopere8e811afab72\\Symfony\\Component\\Form\\Form')) {
            return \true;
        }
        if (!$this->isName($methodCall->name, 'isValid')) {
            return \true;
        }
        $previousNode = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PREVIOUS_NODE);
        if ($previousNode !== null) {
            return \true;
        }
        $variableName = $this->getName($methodCall->var);
        return $variableName === null;
    }
    private function isIsSubmittedByAlreadyCalledOnVariable(\_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $variable) : bool
    {
        $previousMethodCallNamesOnVariable = $this->methodCallManipulator->findMethodCallNamesOnVariable($variable);
        // already checked by isSubmitted()
        return \in_array('isSubmitted', $previousMethodCallNamesOnVariable, \true);
    }
}
