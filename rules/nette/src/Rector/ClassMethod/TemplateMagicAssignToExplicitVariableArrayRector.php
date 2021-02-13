<?php

declare (strict_types=1);
namespace Rector\Nette\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\Nette\NodeAnalyzer\ConditionalTemplateAssignReplacer;
use Rector\Nette\NodeAnalyzer\NetteClassAnalyzer;
use Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer;
use Rector\Nette\NodeAnalyzer\TemplatePropertyAssignCollector;
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
    public function __construct(\Rector\Nette\NodeAnalyzer\TemplatePropertyAssignCollector $templatePropertyAssignCollector, \Rector\Nette\NodeAnalyzer\RenderMethodAnalyzer $renderMethodAnalyzer, \Rector\Nette\NodeAnalyzer\NetteClassAnalyzer $netteClassAnalyzer, \Rector\Nette\NodeFactory\RenderParameterArrayFactory $renderParameterArrayFactory, \Rector\Nette\NodeAnalyzer\ConditionalTemplateAssignReplacer $conditionalTemplateAssignReplacer)
    {
        $this->templatePropertyAssignCollector = $templatePropertyAssignCollector;
        $this->renderMethodAnalyzer = $renderMethodAnalyzer;
        $this->netteClassAnalyzer = $netteClassAnalyzer;
        $this->renderParameterArrayFactory = $renderParameterArrayFactory;
        $this->conditionalTemplateAssignReplacer = $conditionalTemplateAssignReplacer;
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
        $renderMethodCall = $this->renderMethodAnalyzer->machRenderMethodCall($node);
        if (!$renderMethodCall instanceof \PhpParser\Node\Expr\MethodCall) {
            return null;
        }
        if (!isset($renderMethodCall->args[0])) {
            return null;
        }
        $magicTemplatePropertyCalls = $this->templatePropertyAssignCollector->collectMagicTemplatePropertyCalls($node);
        $array = $this->renderParameterArrayFactory->createArray($magicTemplatePropertyCalls);
        if (!$array instanceof \PhpParser\Node\Expr\Array_) {
            return null;
        }
        $this->conditionalTemplateAssignReplacer->processClassMethod($node, $magicTemplatePropertyCalls);
        $renderMethodCall->args[1] = new \PhpParser\Node\Arg($array);
        $this->removeNodes($magicTemplatePropertyCalls->getNodesToRemove());
        return $node;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isNames($classMethod, ['render', 'render*'])) {
            return \true;
        }
        return !$this->netteClassAnalyzer->isInComponent($classMethod);
    }
}
