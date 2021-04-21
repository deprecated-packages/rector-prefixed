<?php

declare(strict_types=1);

namespace Rector\Nette\Rector\ArrayDimFetch;

use Nette\Utils\Strings;
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
use Rector\Naming\ArrayDimFetchRenamer;
use Rector\Nette\Naming\NetteControlNaming;
use Rector\Nette\NodeAnalyzer\ArrayDimFetchAnalyzer;
use Rector\Nette\NodeAnalyzer\AssignAnalyzer;
use Rector\Nette\NodeAnalyzer\ControlDimFetchAnalyzer;
use Rector\Nette\NodeResolver\MethodNamesByInputNamesResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Nette\Tests\Rector\ArrayDimFetch\AnnotateMagicalControlArrayAccessRector\AnnotateMagicalControlArrayAccessRectorTest
 */
final class AnnotateMagicalControlArrayAccessRector extends AbstractRector
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

    public function __construct(
        MethodNamesByInputNamesResolver $methodNamesByInputNamesResolver,
        ArrayDimFetchRenamer $arrayDimFetchRenamer,
        ArrayDimFetchAnalyzer $arrayDimFetchAnalyzer,
        ControlDimFetchAnalyzer $controlDimFetchAnalyzer,
        NetteControlNaming $netteControlNaming,
        AssignAnalyzer $assignAnalyzer
    ) {
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
    public function getNodeTypes(): array
    {
        return [ArrayDimFetch::class];
    }

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Change magic $this["some_component"] to variable assign with @var annotation',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
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
,
                    <<<'CODE_SAMPLE'
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
            ),
            ]);
    }

    /**
     * @param ArrayDimFetch $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        if ($this->shouldSkip($node)) {
            return null;
        }

        $controlName = $this->controlDimFetchAnalyzer->matchNameOnControlVariable($node);
        if ($controlName === null) {
            return null;
        }

        // probably multiplier factory, nothing we can do... yet
        if (Strings::contains($controlName, '-')) {
            return null;
        }

        $variableName = $this->netteControlNaming->createVariableName($controlName);
        $controlObjectType = $this->resolveControlType($node, $controlName);
        $this->assignAnalyzer->addAssignExpressionForFirstCase($variableName, $node, $controlObjectType);

        $classMethod = $node->getAttribute(AttributeKey::METHOD_NODE);
        if ($classMethod instanceof ClassMethod) {
            $this->arrayDimFetchRenamer->renameToVariable($classMethod, $node, $variableName);
        }

        return new Variable($variableName);
    }

    private function shouldSkip(ArrayDimFetch $arrayDimFetch): bool
    {
        if ($this->arrayDimFetchAnalyzer->isBeingAssignedOrInitialized($arrayDimFetch)) {
            return true;
        }

        $parent = $arrayDimFetch->getAttribute(AttributeKey::PARENT_NODE);
        if (! $parent instanceof Isset_ && ! $parent instanceof Unset_) {
            return false;
        }

        return ! $arrayDimFetch->dim instanceof Variable;
    }

    private function resolveControlType(ArrayDimFetch $arrayDimFetch, string $controlName): ObjectType
    {
        $controlTypes = $this->methodNamesByInputNamesResolver->resolveExpr($arrayDimFetch);
        if ($controlTypes === []) {
            throw new NotImplementedYetException($controlName);
        }

        if (! isset($controlTypes[$controlName])) {
            throw new ShouldNotHappenException($controlName);
        }

        return new ObjectType($controlTypes[$controlName]);
    }
}
