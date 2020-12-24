<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Dependency;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\InClassMethodNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Node\InFunctionNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionWithFilename;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ClosureType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType;
class DependencyResolver
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var ExportedNodeResolver */
    private $exportedNodeResolver;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\File\FileHelper $fileHelper, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
    {
        $this->fileHelper = $fileHelper;
        $this->reflectionProvider = $reflectionProvider;
        $this->exportedNodeResolver = $exportedNodeResolver;
    }
    public function resolveDependencies(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, \_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\NodeDependencies
    {
        $dependenciesReflections = [];
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_) {
            if ($node->extends !== null) {
                $this->addClassToDependencies($node->extends->toString(), $dependenciesReflections);
            }
            foreach ($node->implements as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Interface_) {
            foreach ($node->extends as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\InClassMethodNode) {
            $nativeMethod = $scope->getFunction();
            if ($nativeMethod !== null) {
                $parametersAcceptor = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($nativeMethod->getVariants());
                if ($parametersAcceptor instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Node\InFunctionNode) {
            $functionReflection = $scope->getFunction();
            if ($functionReflection !== null) {
                $parametersAcceptor = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants());
                if ($parametersAcceptor instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Closure) {
            /** @var ClosureType $closureType */
            $closureType = $scope->getType($node);
            foreach ($closureType->getParameters() as $parameter) {
                $referencedClasses = $parameter->getType()->getReferencedClasses();
                foreach ($referencedClasses as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            $returnTypeReferencedClasses = $closureType->getReturnType()->getReferencedClasses();
            foreach ($returnTypeReferencedClasses as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
            $functionName = $node->name;
            if ($functionName instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                try {
                    $dependenciesReflections[] = $this->getFunctionReflection($functionName, $scope);
                } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\FunctionNotFoundException $e) {
                    // pass
                }
            } else {
                $calledType = $scope->getType($functionName);
                if ($calledType->isCallable()->yes()) {
                    $variants = $calledType->getCallableParametersAcceptors($scope);
                    foreach ($variants as $variant) {
                        $referencedClasses = $variant->getReturnType()->getReferencedClasses();
                        foreach ($referencedClasses as $referencedClass) {
                            $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                        }
                    }
                }
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
            $classNames = $scope->getType($node->var)->getReferencedClasses();
            foreach ($classNames as $className) {
                $this->addClassToDependencies($className, $dependenciesReflections);
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch || $node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) {
            if ($node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
            } else {
                foreach ($scope->getType($node->class)->getReferencedClasses() as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_ && $node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
            $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\TraitUse) {
            foreach ($node->traits as $traitName) {
                $this->addClassToDependencies($traitName->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Instanceof_) {
            if ($node->class instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Catch_) {
            foreach ($node->types as $type) {
                $this->addClassToDependencies($scope->resolveName($type), $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ArrayDimFetch && $node->dim !== null) {
            $varType = $scope->getType($node->var);
            $dimType = $scope->getType($node->dim);
            foreach ($varType->getOffsetValueType($dimType)->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Foreach_) {
            $exprType = $scope->getType($node->expr);
            if ($node->keyVar !== null) {
                foreach ($exprType->getIterableKeyType()->getReferencedClasses() as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            foreach ($exprType->getIterableValueType()->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ && $this->considerArrayForCallableTest($scope, $node)) {
            $arrayType = $scope->getType($node);
            if (!$arrayType->isCallable()->no()) {
                foreach ($arrayType->getCallableParametersAcceptors($scope) as $variant) {
                    $referencedClasses = $variant->getReturnType()->getReferencedClasses();
                    foreach ($referencedClasses as $referencedClass) {
                        $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                    }
                }
            }
        }
        return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Dependency\NodeDependencies($this->fileHelper, $dependenciesReflections, $this->exportedNodeResolver->resolve($scope->getFile(), $node));
    }
    private function considerArrayForCallableTest(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Array_ $arrayNode) : bool
    {
        if (!isset($arrayNode->items[0])) {
            return \false;
        }
        $itemType = $scope->getType($arrayNode->items[0]->value);
        if (!$itemType instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Constant\ConstantStringType) {
            return \true;
        }
        return $itemType->isClassString();
    }
    /**
     * @param string $className
     * @param ReflectionWithFilename[] $dependenciesReflections
     */
    private function addClassToDependencies(string $className, array &$dependenciesReflections) : void
    {
        try {
            $classReflection = $this->reflectionProvider->getClass($className);
        } catch (\_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\ClassNotFoundException $e) {
            return;
        }
        do {
            $dependenciesReflections[] = $classReflection;
            foreach ($classReflection->getInterfaces() as $interface) {
                $dependenciesReflections[] = $interface;
            }
            foreach ($classReflection->getTraits() as $trait) {
                $dependenciesReflections[] = $trait;
            }
            $classReflection = $classReflection->getParentClass();
        } while ($classReflection !== \false);
    }
    private function getFunctionReflection(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name $nameNode, ?\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope) : \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionWithFilename
    {
        $reflection = $this->reflectionProvider->getFunction($nameNode, $scope);
        if (!$reflection instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionWithFilename) {
            throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        return $reflection;
    }
    /**
     * @param ParametersAcceptorWithPhpDocs $parametersAcceptor
     * @param ReflectionWithFilename[] $dependenciesReflections
     */
    private function extractFromParametersAcceptor(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parametersAcceptor, array &$dependenciesReflections) : void
    {
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            $referencedClasses = \array_merge($parameter->getNativeType()->getReferencedClasses(), $parameter->getPhpDocType()->getReferencedClasses());
            foreach ($referencedClasses as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        }
        $returnTypeReferencedClasses = \array_merge($parametersAcceptor->getNativeReturnType()->getReferencedClasses(), $parametersAcceptor->getPhpDocReturnType()->getReferencedClasses());
        foreach ($returnTypeReferencedClasses as $referencedClass) {
            $this->addClassToDependencies($referencedClass, $dependenciesReflections);
        }
    }
}
