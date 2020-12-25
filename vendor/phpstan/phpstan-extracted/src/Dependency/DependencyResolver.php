<?php

declare (strict_types=1);
namespace PHPStan\Dependency;

use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\Closure;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Foreach_;
use PHPStan\Analyser\Scope;
use PHPStan\File\FileHelper;
use PHPStan\Node\InClassMethodNode;
use PHPStan\Node\InFunctionNode;
use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Reflection\ReflectionWithFilename;
use PHPStan\Type\ClosureType;
use PHPStan\Type\Constant\ConstantStringType;
class DependencyResolver
{
    /** @var FileHelper */
    private $fileHelper;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var ExportedNodeResolver */
    private $exportedNodeResolver;
    public function __construct(\PHPStan\File\FileHelper $fileHelper, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, \PHPStan\Dependency\ExportedNodeResolver $exportedNodeResolver)
    {
        $this->fileHelper = $fileHelper;
        $this->reflectionProvider = $reflectionProvider;
        $this->exportedNodeResolver = $exportedNodeResolver;
    }
    public function resolveDependencies(\PhpParser\Node $node, \PHPStan\Analyser\Scope $scope) : \PHPStan\Dependency\NodeDependencies
    {
        $dependenciesReflections = [];
        if ($node instanceof \PhpParser\Node\Stmt\Class_) {
            if ($node->extends !== null) {
                $this->addClassToDependencies($node->extends->toString(), $dependenciesReflections);
            }
            foreach ($node->implements as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Stmt\Interface_) {
            foreach ($node->extends as $className) {
                $this->addClassToDependencies($className->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \PHPStan\Node\InClassMethodNode) {
            $nativeMethod = $scope->getFunction();
            if ($nativeMethod !== null) {
                $parametersAcceptor = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($nativeMethod->getVariants());
                if ($parametersAcceptor instanceof \PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \PHPStan\Node\InFunctionNode) {
            $functionReflection = $scope->getFunction();
            if ($functionReflection !== null) {
                $parametersAcceptor = \PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants());
                if ($parametersAcceptor instanceof \PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
                    $this->extractFromParametersAcceptor($parametersAcceptor, $dependenciesReflections);
                }
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\Closure) {
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
        } elseif ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            $functionName = $node->name;
            if ($functionName instanceof \PhpParser\Node\Name) {
                try {
                    $dependenciesReflections[] = $this->getFunctionReflection($functionName, $scope);
                } catch (\PHPStan\Broker\FunctionNotFoundException $e) {
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
        } elseif ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            $classNames = $scope->getType($node->var)->getReferencedClasses();
            foreach ($classNames as $className) {
                $this->addClassToDependencies($className, $dependenciesReflections);
            }
            $returnType = $scope->getType($node);
            foreach ($returnType->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\StaticCall || $node instanceof \PhpParser\Node\Expr\ClassConstFetch || $node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            if ($node->class instanceof \PhpParser\Node\Name) {
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
        } elseif ($node instanceof \PhpParser\Node\Expr\New_ && $node->class instanceof \PhpParser\Node\Name) {
            $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
        } elseif ($node instanceof \PhpParser\Node\Stmt\TraitUse) {
            foreach ($node->traits as $traitName) {
                $this->addClassToDependencies($traitName->toString(), $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\Instanceof_) {
            if ($node->class instanceof \PhpParser\Node\Name) {
                $this->addClassToDependencies($scope->resolveName($node->class), $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Stmt\Catch_) {
            foreach ($node->types as $type) {
                $this->addClassToDependencies($scope->resolveName($type), $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\ArrayDimFetch && $node->dim !== null) {
            $varType = $scope->getType($node->var);
            $dimType = $scope->getType($node->dim);
            foreach ($varType->getOffsetValueType($dimType)->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Stmt\Foreach_) {
            $exprType = $scope->getType($node->expr);
            if ($node->keyVar !== null) {
                foreach ($exprType->getIterableKeyType()->getReferencedClasses() as $referencedClass) {
                    $this->addClassToDependencies($referencedClass, $dependenciesReflections);
                }
            }
            foreach ($exprType->getIterableValueType()->getReferencedClasses() as $referencedClass) {
                $this->addClassToDependencies($referencedClass, $dependenciesReflections);
            }
        } elseif ($node instanceof \PhpParser\Node\Expr\Array_ && $this->considerArrayForCallableTest($scope, $node)) {
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
        return new \PHPStan\Dependency\NodeDependencies($this->fileHelper, $dependenciesReflections, $this->exportedNodeResolver->resolve($scope->getFile(), $node));
    }
    private function considerArrayForCallableTest(\PHPStan\Analyser\Scope $scope, \PhpParser\Node\Expr\Array_ $arrayNode) : bool
    {
        if (!isset($arrayNode->items[0])) {
            return \false;
        }
        $itemType = $scope->getType($arrayNode->items[0]->value);
        if (!$itemType instanceof \PHPStan\Type\Constant\ConstantStringType) {
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
        } catch (\PHPStan\Broker\ClassNotFoundException $e) {
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
    private function getFunctionReflection(\PhpParser\Node\Name $nameNode, ?\PHPStan\Analyser\Scope $scope) : \PHPStan\Reflection\ReflectionWithFilename
    {
        $reflection = $this->reflectionProvider->getFunction($nameNode, $scope);
        if (!$reflection instanceof \PHPStan\Reflection\ReflectionWithFilename) {
            throw new \PHPStan\Broker\FunctionNotFoundException((string) $nameNode);
        }
        return $reflection;
    }
    /**
     * @param ParametersAcceptorWithPhpDocs $parametersAcceptor
     * @param ReflectionWithFilename[] $dependenciesReflections
     */
    private function extractFromParametersAcceptor(\PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parametersAcceptor, array &$dependenciesReflections) : void
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
