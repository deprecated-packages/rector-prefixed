<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\NodeAnalyzer\ConditionalTemplateAssignReplacer;
use Rector\Nette\NodeAnalyzer\NetteClassAnalyzer;
use Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer;
use Rector\Nette\NodeAnalyzer\RightAssignTemplateRemover;
use Rector\Nette\NodeAnalyzer\TemplatePropertyAssignCollector;
use Rector\Nette\NodeAnalyzer\TemplatePropertyParametersReplacer;
use Rector\Nette\NodeFactory\RenderParameterArrayFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector\TemplateMagicAssignToExplicitVariableArrayRectorTest
 */
final class TemplateMagicAssignToExplicitVariableArrayRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var TemplatePropertyAssignCollector
     */
    private $templatePropertyAssignCollector;
    /**
     * @var RenderMethodAnalyzer
     */
    private $renderMethodAnalyzer;
    /**
     * @var NetteClassAnalyzer
     */
    private $netteClassAnalyzer;
    /**
     * @var RenderParameterArrayFactory
     */
    private $renderParameterArrayFactory;
    /**
     * @var ConditionalTemplateAssignReplacer
     */
    private $conditionalTemplateAssignReplacer;
    /**
     * @var RightAssignTemplateRemover
     */
    private $rightAssignTemplateRemover;
    /**
     * @var TemplatePropertyParametersReplacer
     */
    private $templatePropertyParametersReplacer;
    public function __construct(\Rector\Nette\NodeAnalyzer\TemplatePropertyAssignCollector $templatePropertyAssignCollector, \Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer $renderMethodAnalyzer, \Rector\Nette\NodeAnalyzer\NetteClassAnalyzer $netteClassAnalyzer, \Rector\Nette\NodeFactory\RenderParameterArrayFactory $renderParameterArrayFactory, \Rector\Nette\NodeAnalyzer\ConditionalTemplateAssignReplacer $conditionalTemplateAssignReplacer, \Rector\Nette\NodeAnalyzer\RightAssignTemplateRemover $rightAssignTemplateRemover, \Rector\Nette\NodeAnalyzer\TemplatePropertyParametersReplacer $templatePropertyParametersReplacer)
    {
        $this->templatePropertyAssignCollector = $templatePropertyAssignCollector;
        $this->renderMethodAnalyzer = $renderMethodAnalyzer;
        $this->netteClassAnalyzer = $netteClassAnalyzer;
        $this->renderParameterArrayFactory = $renderParameterArrayFactory;
        $this->conditionalTemplateAssignReplacer = $conditionalTemplateAssignReplacer;
        $this->rightAssignTemplateRemover = $rightAssignTemplateRemover;
        $this->templatePropertyParametersReplacer = $templatePropertyParametersReplacer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change `$this->templates->{magic}` to `$this->template->render(..., $values)` in components', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

class SomeControl extends Control
{
    public function render()
    {
        $this->template->param = 'some value';
        $this->template->render(__DIR__ . '/poll.latte');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Nette\Application\UI\Control;

class SomeControl extends Control
{
    public function render()
    {
        $this->template->render(__DIR__ . '/poll.latte', ['param' => 'some value']);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        $renderMethodCalls = $this->renderMethodAnalyzer->machRenderMethodCalls($node);
        if ($renderMethodCalls === []) {
            return null;
        }
        if (!$this->haveMethodCallsFirstArgument($renderMethodCalls)) {
            return null;
        }
        // initialize $parameters variable for multiple renders
        if (\count($renderMethodCalls) > 1) {
            return $this->refactorForMultipleRenderMethodCalls($node, $renderMethodCalls);
        }
        return $this->refactorForSingleRenderMethodCall($node, $renderMethodCalls[0]);
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isNames($classMethod, ['render', 'render*'])) {
            return \true;
        }
        return !$this->netteClassAnalyzer->isInComponent($classMethod);
    }
    /**
     * @param MethodCall[] $methodCalls
     */
    private function haveMethodCallsFirstArgument(array $methodCalls) : bool
    {
        foreach ($methodCalls as $methodCall) {
            if (!isset($methodCall->args[0])) {
                return \false;
            }
        }
        return \true;
    }
    private function refactorForSingleRenderMethodCall(\PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node\Expr\MethodCall $renderMethodCall) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $templateParametersAssigns = $this->templatePropertyAssignCollector->collect($classMethod);
        $array = $this->renderParameterArrayFactory->createArray($templateParametersAssigns);
        if (!$array instanceof \PhpParser\Node\Expr\Array_) {
            return null;
        }
        $this->conditionalTemplateAssignReplacer->processClassMethod($templateParametersAssigns);
        $renderMethodCall->args[1] = new \PhpParser\Node\Arg($array);
        foreach ($templateParametersAssigns->getTemplateParameterAssigns() as $alwaysTemplateParameterAssign) {
            $this->removeNode($alwaysTemplateParameterAssign->getAssign());
        }
        $this->rightAssignTemplateRemover->removeInClassMethod($classMethod);
        return $classMethod;
    }
    /**
     * @param MethodCall[] $renderMethodCalls
     */
    private function refactorForMultipleRenderMethodCalls(\PhpParser\Node\Stmt\ClassMethod $classMethod, array $renderMethodCalls) : ?\PhpParser\Node\Stmt\ClassMethod
    {
        $magicTemplateParametersAssigns = $this->templatePropertyAssignCollector->collect($classMethod);
        if ($magicTemplateParametersAssigns->getTemplateParameterAssigns() === []) {
            return null;
        }
        $parametersVariable = new \PhpParser\Node\Expr\Variable('parameters');
        $parametersAssign = new \PhpParser\Node\Expr\Assign($parametersVariable, new \PhpParser\Node\Expr\Array_());
        $assignExpression = new \PhpParser\Node\Stmt\Expression($parametersAssign);
        $classMethod->stmts = \array_merge([$assignExpression], (array) $classMethod->stmts);
        $this->templatePropertyParametersReplacer->replace($magicTemplateParametersAssigns, $parametersVariable);
        foreach ($renderMethodCalls as $renderMethodCall) {
            $renderMethodCall->args[1] = new \PhpParser\Node\Arg($parametersVariable);
        }
        return $classMethod;
    }
}
