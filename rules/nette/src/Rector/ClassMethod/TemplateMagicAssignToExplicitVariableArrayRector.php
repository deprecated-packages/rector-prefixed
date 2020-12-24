<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Nette\NodeFactory\ActionRenderFactory;
use _PhpScoper0a6b37af0871\Rector\Nette\TemplatePropertyAssignCollector;
use _PhpScoper0a6b37af0871\Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Nette\Tests\Rector\ClassMethod\TemplateMagicAssignToExplicitVariableArrayRector\TemplateMagicAssignToExplicitVariableArrayRectorTest
 */
final class TemplateMagicAssignToExplicitVariableArrayRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var TemplatePropertyAssignCollector
     */
    private $templatePropertyAssignCollector;
    /**
     * @var ActionRenderFactory
     */
    private $actionRenderFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Nette\NodeFactory\ActionRenderFactory $actionRenderFactory, \_PhpScoper0a6b37af0871\Rector\Nette\TemplatePropertyAssignCollector $templatePropertyAssignCollector)
    {
        $this->templatePropertyAssignCollector = $templatePropertyAssignCollector;
        $this->actionRenderFactory = $actionRenderFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change `$this->templates->{magic}` to `$this->template->render(..., $values)`', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isObjectType($node, '_PhpScoper0a6b37af0871\\Nette\\Application\\UI\\Control')) {
            return null;
        }
        if (!$node->isPublic()) {
            return null;
        }
        $magicTemplatePropertyCalls = $this->templatePropertyAssignCollector->collectTemplateFileNameVariablesAndNodesToRemove($node);
        $renderMethodCall = $this->createRenderMethodCall($node, $magicTemplatePropertyCalls);
        $node->stmts = \array_merge((array) $node->stmts, [new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($renderMethodCall)]);
        $this->removeNodes($magicTemplatePropertyCalls->getNodesToRemove());
        return $node;
    }
    private function createRenderMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall
    {
        if ($this->isObjectType($classMethod, '_PhpScoper0a6b37af0871\\Nette\\Application\\UI\\Presenter')) {
            return $this->actionRenderFactory->createThisTemplateRenderMethodCall($magicTemplatePropertyCalls);
        }
        return $this->actionRenderFactory->createThisRenderMethodCall($magicTemplatePropertyCalls);
    }
}
