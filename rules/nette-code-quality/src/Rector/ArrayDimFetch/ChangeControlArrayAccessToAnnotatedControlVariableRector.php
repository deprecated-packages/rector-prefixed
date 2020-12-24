<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Unset_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Naming\ArrayDimFetchRenamer;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\NetteCodeQuality\Tests\Rector\ArrayDimFetch\ChangeControlArrayAccessToAnnotatedControlVariableRector\ChangeControlArrayAccessToAnnotatedControlVariableRectorTest
 */
final class ChangeControlArrayAccessToAnnotatedControlVariableRector extends \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\ArrayDimFetch\AbstractArrayDimFetchToAnnotatedControlVariableRector
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var ArrayDimFetchRenamer
     */
    private $arrayDimFetchRenamer;
    public function __construct(\_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver, \_PhpScopere8e811afab72\Rector\Naming\ArrayDimFetchRenamer $arrayDimFetchRenamer)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
        $this->arrayDimFetchRenamer = $arrayDimFetchRenamer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change magic $this["some_component"] to variable assign with @var annotation', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

final class SomePresenter extends Presenter
{
    public function run()
    {
        if ($this['some_form']->isSubmitted()) {
        }
    }

    protected function createComponentSomeForm()
    {
        return new Form();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Presenter;
use Nette\Application\UI\Form;

final class SomePresenter extends Presenter
{
    public function run()
    {
        /** @var \Nette\Application\UI\Form $someForm */
        $someForm = $this['some_form'];
        if ($someForm->isSubmitted()) {
        }
    }

    protected function createComponentSomeForm()
    {
        return new Form();
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    /**
     * @param ArrayDimFetch $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $controlName = $this->controlDimFetchAnalyzer->matchNameOnControlVariable($node);
        if ($controlName === null) {
            return null;
        }
        // probably multiplier factory, nothing we can do... yet
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($controlName, '-')) {
            return null;
        }
        $variableName = $this->netteControlNaming->createVariableName($controlName);
        $controlObjectType = $this->resolveControlType($node, $controlName);
        $this->addAssignExpressionForFirstCase($variableName, $node, $controlObjectType);
        $classMethod = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod) {
            $this->arrayDimFetchRenamer->renameToVariable($classMethod, $node, $variableName);
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
    }
    private function shouldSkip(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        if ($this->isBeingAssignedOrInitialized($arrayDimFetch)) {
            return \true;
        }
        $parent = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Isset_ || $parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Unset_) {
            return !$arrayDimFetch->dim instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
        }
        return \false;
    }
    private function resolveControlType(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $controlName) : \_PhpScopere8e811afab72\PHPStan\Type\ObjectType
    {
        $controlTypes = $this->methodNamesByInputNamesResolver->resolveExpr($arrayDimFetch);
        if ($controlTypes === []) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\NotImplementedYetException($controlName);
        }
        if (!isset($controlTypes[$controlName])) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException($controlName);
        }
        $controlType = $controlTypes[$controlName];
        return new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($controlType);
    }
}
