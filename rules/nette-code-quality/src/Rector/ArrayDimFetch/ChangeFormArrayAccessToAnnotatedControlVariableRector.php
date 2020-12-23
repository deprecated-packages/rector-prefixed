<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Unset_;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\FormVariableInputNameTypeResolver;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\ChangeFormArrayAccessToAnnotatedControlVariableRectorTest
 */
final class ChangeFormArrayAccessToAnnotatedControlVariableRector extends \_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\Rector\ArrayDimFetch\AbstractArrayDimFetchToAnnotatedControlVariableRector
{
    /**
     * @var FormVariableInputNameTypeResolver
     */
    private $formVariableInputNameTypeResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NetteCodeQuality\NodeResolver\FormVariableInputNameTypeResolver $formVariableInputNameTypeResolver)
    {
        $this->formVariableInputNameTypeResolver = $formVariableInputNameTypeResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array access magic on $form to explicit standalone typed variable', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Form;

class SomePresenter
{
    public function run()
    {
        $form = new Form();
        $this->addText('email', 'Email');

        $form['email']->value = 'hey@hi.hello';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Form;

class SomePresenter
{
    public function run()
    {
        $form = new Form();
        $this->addText('email', 'Email');

        /** @var \Nette\Forms\Controls\TextInput $emailControl */
        $emailControl = $form['email'];
        $emailControl->value = 'hey@hi.hello';
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    /**
     * @param ArrayDimFetch $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->isBeingAssignedOrInitialized($node)) {
            return null;
        }
        if ($this->hasParentTypes($node, [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Isset_::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Unset_::class])) {
            return null;
        }
        $inputName = $this->controlDimFetchAnalyzer->matchNameOnFormOrControlVariable($node);
        if ($inputName === null) {
            return null;
        }
        $formVariableName = $this->getName($node->var);
        if ($formVariableName === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        // 1. find previous calls on variable
        $controlType = $this->formVariableInputNameTypeResolver->resolveControlTypeByInputName($node->var, $inputName);
        $controlVariableName = $this->netteControlNaming->createVariableName($inputName);
        $controlObjectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($controlType);
        $this->addAssignExpressionForFirstCase($controlVariableName, $node, $controlObjectType);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable($controlVariableName);
    }
}
