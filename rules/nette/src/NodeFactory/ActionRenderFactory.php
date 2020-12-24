<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
final class ActionRenderFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function createThisRenderMethodCall(\_PhpScopere8e811afab72\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $methodCall = $this->nodeFactory->createMethodCall('this', 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    public function createThisTemplateRenderMethodCall(\_PhpScopere8e811afab72\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall
    {
        $thisTemplatePropertyFetch = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\PropertyFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('this'), 'template');
        $methodCall = $this->nodeFactory->createMethodCall($thisTemplatePropertyFetch, 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    private function addArguments(\_PhpScopere8e811afab72\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($magicTemplatePropertyCalls->getTemplateFileExpr() !== null) {
            $methodCall->args[0] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($magicTemplatePropertyCalls->getTemplateFileExpr());
        }
        if ($magicTemplatePropertyCalls->getTemplateVariables() !== []) {
            $templateVariablesArray = $this->createTemplateVariablesArray($magicTemplatePropertyCalls->getTemplateVariables());
            $methodCall->args[1] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($templateVariablesArray);
        }
    }
    /**
     * @param Expr[] $templateVariables
     */
    private function createTemplateVariablesArray(array $templateVariables) : \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        $array = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_();
        foreach ($templateVariables as $name => $node) {
            $array->items[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($node, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($name));
        }
        return $array;
    }
}
