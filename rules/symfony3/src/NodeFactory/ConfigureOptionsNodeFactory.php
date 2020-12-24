<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Symfony3\NodeFactory;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder;
final class ConfigureOptionsNodeFactory
{
    /**
     * @param array<string, Arg> $namesToArgs
     */
    public function create(array $namesToArgs) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod
    {
        $resolverParam = $this->createParam();
        $args = $this->createArgs($namesToArgs);
        $setDefaultsMethodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($resolverParam->var, new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('setDefaults'), $args);
        $methodBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\MethodBuilder('configureOptions');
        $methodBuilder->makePublic();
        $methodBuilder->addParam($resolverParam);
        $methodBuilder->addStmt($setDefaultsMethodCall);
        return $methodBuilder->getNode();
    }
    private function createParam() : \_PhpScopere8e811afab72\PhpParser\Node\Param
    {
        $paramBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\ParamBuilder('resolver');
        $paramBuilder->setType(new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\OptionsResolver\\OptionsResolver'));
        return $paramBuilder->getNode();
    }
    /**
     * @param Arg[] $namesToArgs
     * @return Arg[]
     */
    private function createArgs(array $namesToArgs) : array
    {
        $array = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_();
        foreach (\array_keys($namesToArgs) as $optionName) {
            $array->items[] = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($this->createNull(), new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_($optionName));
        }
        return [new \_PhpScopere8e811afab72\PhpParser\Node\Arg($array)];
    }
    private function createNull() : \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch
    {
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ConstFetch(new \_PhpScopere8e811afab72\PhpParser\Node\Name('null'));
    }
}
