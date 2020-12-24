<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param;
use _PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory;
use _PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a6b37af0871\Symfony\Component\Form\Extension\Core\Type\TextType;
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\NodeFactory $nodeFactory, \_PhpScoper0a6b37af0871\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeFactory = $nodeFactory;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @api
     * @param MethodCall[] $methodCalls
     */
    public function createFromNetteFormMethodCalls(array $methodCalls) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        $formBuilderVariable = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('formBuilder');
        // public function buildForm(\Symfony\Component\Form\FormBuilderInterface $formBuilder, array $options)
        $buildFormClassMethod = $this->nodeFactory->createPublicMethod('buildForm');
        $buildFormClassMethod->params[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param($formBuilderVariable, null, new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\FormBuilderInterface'));
        $buildFormClassMethod->params[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Param(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('options'), null, new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('array'));
        $symfonyMethodCalls = $this->createBuildFormMethodCalls($methodCalls, $formBuilderVariable);
        $buildFormClassMethod->stmts = $symfonyMethodCalls;
        $formTypeClass = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_('SomeFormType');
        $formTypeClass->extends = new \_PhpScoper0a6b37af0871\PhpParser\Node\Name\FullyQualified('_PhpScoper0a6b37af0871\\Symfony\\Component\\Form\\AbstractType');
        $formTypeClass->stmts[] = $buildFormClassMethod;
        return $formTypeClass;
    }
    /**
     * @param MethodCall[] $methodCalls
     * @return Expression[]
     */
    private function createBuildFormMethodCalls(array $methodCalls, \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable $formBuilderVariable) : array
    {
        $buildFormMethodCalls = [];
        // create symfony form from nette form method calls
        foreach ($methodCalls as $methodCall) {
            if ($this->nodeNameResolver->isName($methodCall->name, 'addText')) {
                $optionsArray = $this->createOptionsArray($methodCall);
                $formTypeClassConstant = $this->nodeFactory->createClassConstReference(\_PhpScoper0a6b37af0871\Symfony\Component\Form\Extension\Core\Type\TextType::class);
                $args = [$methodCall->args[0], new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($formTypeClassConstant)];
                if ($optionsArray instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_) {
                    $args[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($optionsArray);
                }
                $methodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall($formBuilderVariable, 'add', $args);
                $buildFormMethodCalls[] = new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($methodCall);
            }
        }
        return $buildFormMethodCalls;
    }
    private function createOptionsArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_
    {
        if (!isset($methodCall->args[1])) {
            return null;
        }
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Array_([new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayItem($methodCall->args[1]->value, new \_PhpScoper0a6b37af0871\PhpParser\Node\Scalar\String_('label'))]);
    }
}
