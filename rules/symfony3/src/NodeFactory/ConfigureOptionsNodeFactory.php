<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Symfony3\NodeFactory;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder;
final class ConfigureOptionsNodeFactory
{
    /**
     * @param array<string, Arg> $namesToArgs
     */
    public function create(array $namesToArgs) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $resolverParam = $this->createParam();
        $args = $this->createArgs($namesToArgs);
        $setDefaultsMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($resolverParam->var, new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('setDefaults'), $args);
        $methodBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\MethodBuilder('configureOptions');
        $methodBuilder->makePublic();
        $methodBuilder->addParam($resolverParam);
        $methodBuilder->addStmt($setDefaultsMethodCall);
        return $methodBuilder->getNode();
    }
    private function createParam() : \_PhpScoper0a6b37af0871\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Builder\ParamBuilder('resolver');
        $paramBuilder->setType(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Symfony\\Component\\OptionsResolver\\OptionsResolver'));
        return $paramBuilder->getNode();
    }
    /**
     * @param Arg[] $namesToArgs
     * @return Arg[]
     */
    private function createArgs(array $namesToArgs) : array
    {
        $array = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_();
        foreach (\array_keys($namesToArgs) as $optionName) {
            $array->items[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem($this->createNull(), new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_($optionName));
        }
        return [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($array)];
    }
    private function createNull() : \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ConstFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Name('null'));
    }
}
