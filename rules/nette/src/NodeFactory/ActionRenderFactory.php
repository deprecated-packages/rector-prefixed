<?php

declare (strict_types=1);
namespace Rector\Nette\NodeFactory;

use PhpParser\Node\Arg;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Scalar\String_;
use Rector\Core\PhpParser\Node\NodeFactory;
use Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
final class ActionRenderFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function createThisRenderMethodCall(\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \PhpParser\Node\Expr\MethodCall
    {
        $methodCall = $this->nodeFactory->createMethodCall('this', 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    public function createThisTemplateRenderMethodCall(\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \PhpParser\Node\Expr\MethodCall
    {
        $thisTemplatePropertyFetch = new \PhpParser\Node\Expr\PropertyFetch(new \PhpParser\Node\Expr\Variable('this'), 'template');
        $methodCall = $this->nodeFactory->createMethodCall($thisTemplatePropertyFetch, 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    private function addArguments(\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls, \PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($magicTemplatePropertyCalls->getFirstTemplateFileExpr() !== null) {
            $methodCall->args[0] = new \PhpParser\Node\Arg($magicTemplatePropertyCalls->getFirstTemplateFileExpr());
        }
        $templateVariablesArray = $this->createTemplateVariablesArray($magicTemplatePropertyCalls);
        if ($templateVariablesArray->items === []) {
            return;
        }
        $methodCall->args[1] = new \PhpParser\Node\Arg($templateVariablesArray);
    }
    private function createTemplateVariablesArray(\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \PhpParser\Node\Expr\Array_
    {
        $array = new \PhpParser\Node\Expr\Array_();
        foreach ($magicTemplatePropertyCalls->getTemplateVariables() as $name => $expr) {
            $array->items[] = new \PhpParser\Node\Expr\ArrayItem($expr, new \PhpParser\Node\Scalar\String_($name));
        }
        foreach ($magicTemplatePropertyCalls->getConditionalVariableNames() as $variableName) {
            $array->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Expr\Variable($variableName), new \PhpParser\Node\Scalar\String_($variableName));
        }
        return $array;
    }
}
