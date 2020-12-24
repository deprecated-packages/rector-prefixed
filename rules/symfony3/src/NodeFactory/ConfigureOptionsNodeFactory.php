<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Symfony3\NodeFactory;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ParamBuilder;
final class ConfigureOptionsNodeFactory
{
    /**
     * @param array<string, Arg> $namesToArgs
     */
    public function create(array $namesToArgs) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod
    {
        $resolverParam = $this->createParam();
        $args = $this->createArgs($namesToArgs);
        $setDefaultsMethodCall = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall($resolverParam->var, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier('setDefaults'), $args);
        $methodBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\MethodBuilder('configureOptions');
        $methodBuilder->makePublic();
        $methodBuilder->addParam($resolverParam);
        $methodBuilder->addStmt($setDefaultsMethodCall);
        return $methodBuilder->getNode();
    }
    private function createParam() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Builder\ParamBuilder('resolver');
        $paramBuilder->setType(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('_PhpScoper2a4e7ab1ecbc\\Symfony\\Component\\OptionsResolver\\OptionsResolver'));
        return $paramBuilder->getNode();
    }
    /**
     * @param Arg[] $namesToArgs
     * @return Arg[]
     */
    private function createArgs(array $namesToArgs) : array
    {
        $array = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_();
        foreach (\array_keys($namesToArgs) as $optionName) {
            $array->items[] = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayItem($this->createNull(), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($optionName));
        }
        return [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg($array)];
    }
    private function createNull() : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('null'));
    }
}
