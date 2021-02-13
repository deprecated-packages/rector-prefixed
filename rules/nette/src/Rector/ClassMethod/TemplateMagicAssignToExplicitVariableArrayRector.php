<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\NodeAnalyzer\NetteClassAnalyzer;
use Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer;
use Rector\Nette\NodeFactory\ActionRenderFactory;
use Rector\Nette\TemplatePropertyAssignCollector;
use Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
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
     * @var ActionRenderFactory
     */
    private $actionRenderFactory;
    /**
     * @var RenderMethodAnalyzer
     */
    private $renderMethodAnalyzer;
    /**
     * @var NetteClassAnalyzer
     */
    private $netteClassAnalyzer;
    public function __construct(\Rector\Nette\NodeFactory\ActionRenderFactory $actionRenderFactory, \Rector\Nette\TemplatePropertyAssignCollector $templatePropertyAssignCollector, \Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer $renderMethodAnalyzer, \Rector\Nette\NodeAnalyzer\NetteClassAnalyzer $netteClassAnalyzer)
    {
        $this->templatePropertyAssignCollector = $templatePropertyAssignCollector;
        $this->actionRenderFactory = $actionRenderFactory;
        $this->renderMethodAnalyzer = $renderMethodAnalyzer;
        $this->netteClassAnalyzer = $netteClassAnalyzer;
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
     * @return string[]
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
        $magicTemplatePropertyCalls = $this->templatePropertyAssignCollector->collectMagicTemplatePropertyCalls($node);
        if ($magicTemplatePropertyCalls->hasMultipleTemplateFileExprs()) {
            return null;
        }
        $this->replaceConditionalAssignsWithVariables($node, $magicTemplatePropertyCalls);
        $renderMethodCall = $this->actionRenderFactory->createThisTemplateRenderMethodCall($magicTemplatePropertyCalls);
        $node->stmts = \array_merge((array) $node->stmts, [new \PhpParser\Node\Stmt\Expression($renderMethodCall)]);
        $this->removeNodes($magicTemplatePropertyCalls->getNodesToRemove());
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isNames($classMethod, ['render', 'render*'])) {
            return \true;
        }
        if (!$this->netteClassAnalyzer->isInComponent($classMethod)) {
            return \true;
        }
        return $this->renderMethodAnalyzer->hasConditionalTemplateAssigns($classMethod);
    }
    private function replaceConditionalAssignsWithVariables(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) use($magicTemplatePropertyCalls) : ?Assign {
            if (!$node instanceof \PhpParser\Node\Expr\Assign) {
                return null;
            }
            $variableName = $this->matchConditionalAssignVariableName($node, $magicTemplatePropertyCalls->getConditionalAssigns());
            if ($variableName === null) {
                return null;
            }
            return new \PhpParser\Node\Expr\Assign(new \PhpParser\Node\Expr\Variable($variableName), $node->expr);
        });
    }
    /**
     * @param array<string, Assign[]> $condtionalAssignsByName
     */
    private function matchConditionalAssignVariableName(\PhpParser\Node\Expr\Assign $assign, array $condtionalAssignsByName) : ?string
    {
        foreach ($condtionalAssignsByName as $name => $condtionalAssigns) {
            if (!$this->betterStandardPrinter->isNodeEqual($assign, $condtionalAssigns)) {
                continue;
            }
            return $name;
        }
        return null;
    }
}
