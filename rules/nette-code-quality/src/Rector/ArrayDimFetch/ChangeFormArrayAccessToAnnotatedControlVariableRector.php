<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\Unset_;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NetteCodeQuality\Naming\NetteControlNaming;
use Rector\NetteCodeQuality\NodeAnalyzer\ArrayDimFetchAnalyzer;
use Rector\NetteCodeQuality\NodeAnalyzer\AssignAnalyzer;
use Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use Rector\NetteCodeQuality\NodeResolver\FormVariableInputNameTypeResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210309\Symplify\PackageBuilder\Php\TypeChecker;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\ArrayDimFetch\ChangeFormArrayAccessToAnnotatedControlVariableRector\ChangeFormArrayAccessToAnnotatedControlVariableRectorTest
 */
final class ChangeFormArrayAccessToAnnotatedControlVariableRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var FormVariableInputNameTypeResolver
     */
    private $formVariableInputNameTypeResolver;
    /**
     * @var TypeChecker
     */
    private $typeChecker;
    /**
     * @var ArrayDimFetchAnalyzer
     */
    private $arrayDimFetchAnalyzer;
    /**
     * @var NetteControlNaming
     */
    private $netteControlNaming;
    /**
     * @var AssignAnalyzer
     */
    private $assignAnalyzer;
    /**
     * @var ControlDimFetchAnalyzer
     */
    private $controlDimFetchAnalyzer;
    public function __construct(\Rector\NetteCodeQuality\NodeResolver\FormVariableInputNameTypeResolver $formVariableInputNameTypeResolver, \RectorPrefix20210309\Symplify\PackageBuilder\Php\TypeChecker $typeChecker, \Rector\NetteCodeQuality\NodeAnalyzer\ArrayDimFetchAnalyzer $arrayDimFetchAnalyzer, \Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \Rector\NetteCodeQuality\NodeAnalyzer\AssignAnalyzer $assignAnalyzer, \Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer)
    {
        $this->formVariableInputNameTypeResolver = $formVariableInputNameTypeResolver;
        $this->typeChecker = $typeChecker;
        $this->arrayDimFetchAnalyzer = $arrayDimFetchAnalyzer;
        $this->netteControlNaming = $netteControlNaming;
        $this->assignAnalyzer = $assignAnalyzer;
        $this->controlDimFetchAnalyzer = $controlDimFetchAnalyzer;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change array access magic on $form to explicit standalone typed variable', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @param ArrayDimFetch $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->arrayDimFetchAnalyzer->isBeingAssignedOrInitialized($node)) {
            return null;
        }
        $parent = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($this->typeChecker->isInstanceOf($parent, [\PhpParser\Node\Expr\Isset_::class, \PhpParser\Node\Stmt\Unset_::class])) {
            return null;
        }
        $inputName = $this->controlDimFetchAnalyzer->matchNameOnFormOrControlVariable($node);
        if ($inputName === null) {
            return null;
        }
        $formVariableName = $this->getName($node->var);
        if ($formVariableName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // 1. find previous calls on variable
        $controlType = $this->formVariableInputNameTypeResolver->resolveControlTypeByInputName($node->var, $inputName);
        $controlVariableName = $this->netteControlNaming->createVariableName($inputName);
        $controlObjectType = new \PHPStan\Type\ObjectType($controlType);
        $this->assignAnalyzer->addAssignExpressionForFirstCase($controlVariableName, $node, $controlObjectType);
        return new \PhpParser\Node\Expr\Variable($controlVariableName);
    }
}
