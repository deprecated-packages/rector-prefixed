<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteToSymfony;

use _PhpScopere8e811afab72\PhpParser\Node\Arg;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType;
final class SymfonyFormAbstractTypeFactory
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @api
     * @param MethodCall[] $methodCalls
     */
    public function createFromNetteFormMethodCalls(array $methodCalls) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        $formBuilderVariable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('formBuilder');
        // public function buildForm(\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
        $buildFormClassMethod = $this->nodeFactory->createPublicMethod('buildForm');
        $buildFormClassMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param($formBuilderVariable, null, new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\FormBuilderInterface'));
        $buildFormClassMethod->params[] = new \_PhpScopere8e811afab72\PhpParser\Node\Param(new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable('options'), null, new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('array'));
        $symfonyMethodCalls = $this->createBuildFormMethodCalls($methodCalls, $formBuilderVariable);
        $buildFormClassMethod->stmts = $symfonyMethodCalls;
        $formTypeClass = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_('SomeFormType');
        $formTypeClass->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\Symfony\\Component\\Form\\AbstractType');
        $formTypeClass->stmts[] = $buildFormClassMethod;
        return $formTypeClass;
    }
    /**
     * @param MethodCall[] $methodCalls
     * @return Expression[]
     */
    private function createBuildFormMethodCalls(array $methodCalls, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable $formBuilderVariable) : array
    {
        $buildFormMethodCalls = [];
        // create symfony form from nette form method calls
        foreach ($methodCalls as $methodCall) {
            if ($this->nodeNameResolver->isName($methodCall->name, 'addText')) {
                $optionsArray = $this->createOptionsArray($methodCall);
                $formTypeClassConstant = $this->nodeFactory->createClassConstReference(\_PhpScopere8e811afab72\Symfony\Component\Form\Extension\Core\Type\TextType::class);
                $args = [$methodCall->args[0], new \_PhpScopere8e811afab72\PhpParser\Node\Arg($formTypeClassConstant)];
                if ($optionsArray instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_) {
                    $args[] = new \_PhpScopere8e811afab72\PhpParser\Node\Arg($optionsArray);
                }
                $methodCall = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall($formBuilderVariable, 'add', $args);
                $buildFormMethodCalls[] = new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($methodCall);
            }
        }
        return $buildFormMethodCalls;
    }
    private function createOptionsArray(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_
    {
        if (!isset($methodCall->args[1])) {
            return null;
        }
        return new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_([new \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayItem($methodCall->args[1]->value, new \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_('label'))]);
    }
}
