<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Symfony3\NodeFactory;

use _PhpScoperb75b35f52b74\PhpParser\Node\Arg;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder;
final class ConfigureOptionsNodeFactory
{
    /**
     * @param array<string, Arg> $namesToArgs
     */
    public function create(array $namesToArgs) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $resolverParam = $this->createParam();
        $args = $this->createArgs($namesToArgs);
        $setDefaultsMethodCall = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($resolverParam->var, new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier('setDefaults'), $args);
        $methodBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\MethodBuilder('configureOptions');
        $methodBuilder->makePublic();
        $methodBuilder->addParam($resolverParam);
        $methodBuilder->addStmt($setDefaultsMethodCall);
        return $methodBuilder->getNode();
    }
    private function createParam() : \_PhpScoperb75b35f52b74\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Builder\ParamBuilder('resolver');
        $paramBuilder->setType(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified('_PhpScoperb75b35f52b74\\Symfony\\Component\\OptionsResolver\\OptionsResolver'));
        return $paramBuilder->getNode();
    }
    /**
     * @param Arg[] $namesToArgs
     * @return Arg[]
     */
    private function createArgs(array $namesToArgs) : array
    {
        $array = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Array_();
        foreach (\array_keys($namesToArgs) as $optionName) {
            $array->items[] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayItem($this->createNull(), new \_PhpScoperb75b35f52b74\PhpParser\Node\Scalar\String_($optionName));
        }
        return [new \_PhpScoperb75b35f52b74\PhpParser\Node\Arg($array)];
    }
    private function createNull() : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ConstFetch(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name('null'));
    }
}
