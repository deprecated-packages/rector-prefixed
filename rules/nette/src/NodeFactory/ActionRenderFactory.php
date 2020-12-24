<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Nette\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoperb75b35f52b74\Rector\Nette\ValueObject\MagicTemplatePropertyCalls;
final class ActionRenderFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory)
    {
        $this->nodeFactory = $nodeFactory;
    }
    public function createThisRenderMethodCall(\_PhpScoperb75b35f52b74\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $methodCall = $this->nodeFactory->createMethodCall('this', 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    public function createThisTemplateRenderMethodCall(\_PhpScoperb75b35f52b74\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $thisTemplatePropertyFetch = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable('this'), 'template');
        $methodCall = $this->nodeFactory->createMethodCall($thisTemplatePropertyFetch, 'render');
        $this->addArguments($magicTemplatePropertyCalls, $methodCall);
        return $methodCall;
    }
    private function addArguments(\_PhpScoperb75b35f52b74\Rector\Nette\ValueObject\MagicTemplatePropertyCalls $magicTemplatePropertyCalls, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : void
    {
        if ($magicTemplatePropertyCalls->getTemplateFileExpr() !== null) {
            $methodCall->args[0] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($magicTemplatePropertyCalls->getTemplateFileExpr());
        }
        if ($magicTemplatePropertyCalls->getTemplateVariables() !== []) {
            $templateVariablesArray = $this->createTemplateVariablesArray($magicTemplatePropertyCalls->getTemplateVariables());
            $methodCall->args[1] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($templateVariablesArray);
        }
    }
    /**
     * @param Expr[] $templateVariables
     */
    private function createTemplateVariablesArray(array $templateVariables) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_
    {
        $array = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
        foreach ($templateVariables as $name => $node) {
            $array->items[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($node, new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($name));
        }
        return $array;
    }
}
