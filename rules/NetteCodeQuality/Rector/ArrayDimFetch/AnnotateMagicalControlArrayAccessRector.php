<?php

declare (strict_types=1);
namespace Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use RectorPrefix20210312\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Isset_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Unset_;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\NotImplementedYetException;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticInstanceOf;
use Rector\Naming\ArrayDimFetchRenamer;
use Rector\NetteCodeQuality\Naming\NetteControlNaming;
use Rector\NetteCodeQuality\NodeAnalyzer\ArrayDimFetchAnalyzer;
use Rector\NetteCodeQuality\NodeAnalyzer\AssignAnalyzer;
use Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Tests\NetteCodeQuality\Rector\ArrayDimFetch\AnnotateMagicalControlArrayAccessRector\AnnotateMagicalControlArrayAccessRectorTest
 */
final class AnnotateMagicalControlArrayAccessRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var MethodNamesByInputNamesResolver
     */
    private $methodNamesByInputNamesResolver;
    /**
     * @var ArrayDimFetchRenamer
     */
    private $arrayDimFetchRenamer;
    /**
     * @var ArrayDimFetchAnalyzer
     */
    private $arrayDimFetchAnalyzer;
    /**
     * @var ControlDimFetchAnalyzer
     */
    private $controlDimFetchAnalyzer;
    /**
     * @var NetteControlNaming
     */
    private $netteControlNaming;
    /**
     * @var AssignAnalyzer
     */
    private $assignAnalyzer;
    public function __construct(\Rector\NetteCodeQuality\NodeResolver\MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver, \Rector\Naming\ArrayDimFetchRenamer $arrayDimFetchRenamer, \Rector\NetteCodeQuality\NodeAnalyzer\ArrayDimFetchAnalyzer $arrayDimFetchAnalyzer, \Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \Rector\NetteCodeQuality\NodeAnalyzer\AssignAnalyzer $assignAnalyzer)
    {
        $this->methodNamesByInputNamesResolver = $methodNamesByInputNamesResolver;
        $this->arrayDimFetchRenamer = $arrayDimFetchRenamer;
        $this->arrayDimFetchAnalyzer = $arrayDimFetchAnalyzer;
        $this->controlDimFetchAnalyzer = $controlDimFetchAnalyzer;
        $this->netteControlNaming = $netteControlNaming;
        $this->assignAnalyzer = $assignAnalyzer;
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
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change magic $this["some_component"] to variable assign with @var annotation', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
     * @param ArrayDimFetch $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $controlName = $this->controlDimFetchAnalyzer->matchNameOnControlVariable($node);
        if ($controlName === null) {
            return null;
        }
        // probably multiplier factory, nothing we can do... yet
        if (\RectorPrefix20210312\Nette\Utils\Strings::contains($controlName, '-')) {
            return null;
        }
        $variableName = $this->netteControlNaming->createVariableName($controlName);
        $controlObjectType = $this->resolveControlType($node, $controlName);
        $this->assignAnalyzer->addAssignExpressionForFirstCase($variableName, $node, $controlObjectType);
        $classMethod = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            $this->arrayDimFetchRenamer->renameToVariable($classMethod, $node, $variableName);
        }
        return new \PhpParser\Node\Expr\Variable($variableName);
    }
    private function shouldSkip(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        if ($this->arrayDimFetchAnalyzer->isBeingAssignedOrInitialized($arrayDimFetch)) {
            return \true;
        }
        $parent = $arrayDimFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (\Rector\Core\Util\StaticInstanceOf::isOneOf($parent, [\PhpParser\Node\Expr\Isset_::class, \PhpParser\Node\Stmt\Unset_::class])) {
            return !$arrayDimFetch->dim instanceof \PhpParser\Node\Expr\Variable;
        }
        return \false;
    }
    private function resolveControlType(\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $controlName) : \PHPStan\Type\ObjectType
    {
        $controlTypes = $this->methodNamesByInputNamesResolver->resolveExpr($arrayDimFetch);
        if ($controlTypes === []) {
            throw new \Rector\Core\Exception\NotImplementedYetException($controlName);
        }
        if (!isset($controlTypes[$controlName])) {
            throw new \Rector\Core\Exception\ShouldNotHappenException($controlName);
        }
        return new \PHPStan\Type\ObjectType($controlTypes[$controlName]);
    }
}
