<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Rules;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\NonexistentParentClassType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType;
class FunctionDefinitionCheck
{
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\Rules\ClassCaseSensitivityCheck */
    private $classCaseSensitivityCheck;
    /** @var PhpVersion */
    private $phpVersion;
    /** @var bool */
    private $checkClassCaseSensitivity;
    /** @var bool */
    private $checkThisOnly;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassCaseSensitivityCheck $classCaseSensitivityCheck, \_PhpScoper2a4e7ab1ecbc\PHPStan\Php\PhpVersion $phpVersion, bool $checkClassCaseSensitivity, bool $checkThisOnly)
    {
        $this->reflectionProvider = $reflectionProvider;
        $this->classCaseSensitivityCheck = $classCaseSensitivityCheck;
        $this->phpVersion = $phpVersion;
        $this->checkClassCaseSensitivity = $checkClassCaseSensitivity;
        $this->checkThisOnly = $checkThisOnly;
    }
    /**
     * @param \PhpParser\Node\Stmt\Function_ $function
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @return RuleError[]
     */
    public function checkFunction(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_ $function, \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\FunctionReflection $functionReflection, string $parameterMessage, string $returnMessage, string $unionTypesMessage) : array
    {
        $parametersAcceptor = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($functionReflection->getVariants());
        return $this->checkParametersAcceptor($parametersAcceptor, $function, $parameterMessage, $returnMessage, $unionTypesMessage);
    }
    /**
     * @param \PHPStan\Analyser\Scope $scope
     * @param \PhpParser\Node\Param[] $parameters
     * @param \PhpParser\Node\Identifier|\PhpParser\Node\Name|\PhpParser\Node\NullableType|\PhpParser\Node\UnionType|null $returnTypeNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @return \PHPStan\Rules\RuleError[]
     */
    public function checkAnonymousFunction(\_PhpScoper2a4e7ab1ecbc\PHPStan\Analyser\Scope $scope, array $parameters, $returnTypeNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage) : array
    {
        $errors = [];
        $unionTypeReported = \false;
        foreach ($parameters as $param) {
            if ($param->type === null) {
                continue;
            }
            if (!$unionTypeReported && $param->type instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType && !$this->phpVersion->supportsNativeUnionTypes()) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($param->getLine())->nonIgnorable()->build();
                $unionTypeReported = \true;
            }
            if (!$param->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable || !\is_string($param->var->name)) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            $type = $scope->getFunctionType($param->type, \false, \false);
            if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $param->var->name, 'void'))->line($param->type->getLine())->nonIgnorable()->build();
            }
            foreach ($type->getReferencedClasses() as $class) {
                if (!$this->reflectionProvider->hasClass($class) || $this->reflectionProvider->getClass($class)->isTrait()) {
                    $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $param->var->name, $class))->line($param->type->getLine())->build();
                } elseif ($this->checkClassCaseSensitivity) {
                    $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair($class, $param->type)]));
                }
            }
        }
        if ($this->phpVersion->deprecatesRequiredParameterAfterOptional()) {
            $errors = \array_merge($errors, $this->checkRequiredParameterAfterOptional($parameters));
        }
        if ($returnTypeNode === null) {
            return $errors;
        }
        if (!$unionTypeReported && $returnTypeNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType && !$this->phpVersion->supportsNativeUnionTypes()) {
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($returnTypeNode->getLine())->nonIgnorable()->build();
        }
        $returnType = $scope->getFunctionType($returnTypeNode, \false, \false);
        foreach ($returnType->getReferencedClasses() as $returnTypeClass) {
            if (!$this->reflectionProvider->hasClass($returnTypeClass) || $this->reflectionProvider->getClass($returnTypeClass)->isTrait()) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $returnTypeClass))->line($returnTypeNode->getLine())->build();
            } elseif ($this->checkClassCaseSensitivity) {
                $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames([new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair($returnTypeClass, $returnTypeNode)]));
            }
        }
        return $errors;
    }
    /**
     * @param PhpMethodFromParserNodeReflection $methodReflection
     * @param ClassMethod $methodNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @return RuleError[]
     */
    public function checkClassMethod(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection $methodReflection, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $methodNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage) : array
    {
        /** @var \PHPStan\Reflection\ParametersAcceptorWithPhpDocs $parametersAcceptor */
        $parametersAcceptor = \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());
        return $this->checkParametersAcceptor($parametersAcceptor, $methodNode, $parameterMessage, $returnMessage, $unionTypesMessage);
    }
    /**
     * @param ParametersAcceptor $parametersAcceptor
     * @param FunctionLike $functionNode
     * @param string $parameterMessage
     * @param string $returnMessage
     * @param string $unionTypesMessage
     * @return RuleError[]
     */
    private function checkParametersAcceptor(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\FunctionLike $functionNode, string $parameterMessage, string $returnMessage, string $unionTypesMessage) : array
    {
        $errors = [];
        $parameterNodes = $functionNode->getParams();
        if (!$this->phpVersion->supportsNativeUnionTypes()) {
            $unionTypeReported = \false;
            foreach ($parameterNodes as $parameterNode) {
                if (!$parameterNode->type instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType) {
                    continue;
                }
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($parameterNode->getLine())->nonIgnorable()->build();
                $unionTypeReported = \true;
                break;
            }
            if (!$unionTypeReported && $functionNode->getReturnType() instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\UnionType) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message($unionTypesMessage)->line($functionNode->getReturnType()->getLine())->nonIgnorable()->build();
            }
        }
        if ($this->phpVersion->deprecatesRequiredParameterAfterOptional()) {
            $errors = \array_merge($errors, $this->checkRequiredParameterAfterOptional($parameterNodes));
        }
        $returnTypeNode = $functionNode->getReturnType() ?? $functionNode;
        foreach ($parametersAcceptor->getParameters() as $parameter) {
            $referencedClasses = $this->getParameterReferencedClasses($parameter);
            $parameterNode = null;
            $parameterNodeCallback = function () use($parameter, $parameterNodes, &$parameterNode) : Param {
                if ($parameterNode === null) {
                    $parameterNode = $this->getParameterNode($parameter->getName(), $parameterNodes);
                }
                return $parameterNode;
            };
            if ($parameter instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs && $parameter->getNativeType() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VoidType) {
                $parameterVar = $parameterNodeCallback()->var;
                if (!$parameterVar instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable || !\is_string($parameterVar->name)) {
                    throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
                }
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameterVar->name, 'void'))->line($parameterNodeCallback()->getLine())->nonIgnorable()->build();
            }
            foreach ($referencedClasses as $class) {
                if ($this->reflectionProvider->hasClass($class) && !$this->reflectionProvider->getClass($class)->isTrait()) {
                    continue;
                }
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameter->getName(), $class))->line($parameterNodeCallback()->getLine())->build();
            }
            if ($this->checkClassCaseSensitivity) {
                $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($parameterNodeCallback) : ClassNameNodePair {
                    return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair($class, $parameterNodeCallback());
                }, $referencedClasses)));
            }
            if (!$parameter->getType() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NonexistentParentClassType) {
                continue;
            }
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($parameterMessage, $parameter->getName(), $parameter->getType()->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly())))->line($parameterNodeCallback()->getLine())->build();
        }
        $returnTypeReferencedClasses = $this->getReturnTypeReferencedClasses($parametersAcceptor);
        foreach ($returnTypeReferencedClasses as $class) {
            if ($this->reflectionProvider->hasClass($class) && !$this->reflectionProvider->getClass($class)->isTrait()) {
                continue;
            }
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $class))->line($returnTypeNode->getLine())->build();
        }
        if ($this->checkClassCaseSensitivity) {
            $errors = \array_merge($errors, $this->classCaseSensitivityCheck->checkClassNames(\array_map(static function (string $class) use($returnTypeNode) : ClassNameNodePair {
                return new \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\ClassNameNodePair($class, $returnTypeNode);
            }, $returnTypeReferencedClasses)));
        }
        if ($parametersAcceptor->getReturnType() instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\NonexistentParentClassType) {
            $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf($returnMessage, $parametersAcceptor->getReturnType()->describe(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\VerbosityLevel::typeOnly())))->line($returnTypeNode->getLine())->build();
        }
        return $errors;
    }
    /**
     * @param Param[] $parameterNodes
     * @return RuleError[]
     */
    private function checkRequiredParameterAfterOptional(array $parameterNodes) : array
    {
        /** @var string|null $optionalParameter */
        $optionalParameter = null;
        $errors = [];
        foreach ($parameterNodes as $parameterNode) {
            if (!$parameterNode->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            if (!\is_string($parameterNode->var->name)) {
                throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
            }
            $parameterName = $parameterNode->var->name;
            if ($optionalParameter !== null && $parameterNode->default === null && !$parameterNode->variadic) {
                $errors[] = \_PhpScoper2a4e7ab1ecbc\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Deprecated in PHP 8.0: Required parameter $%s follows optional parameter $%s.', $parameterName, $optionalParameter))->line($parameterNode->getStartLine())->nonIgnorable()->build();
                continue;
            }
            if ($parameterNode->default === null) {
                continue;
            }
            if ($parameterNode->type === null) {
                $optionalParameter = $parameterName;
                continue;
            }
            $defaultValue = $parameterNode->default;
            if (!$defaultValue instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ConstFetch) {
                $optionalParameter = $parameterName;
                continue;
            }
            $constantName = $defaultValue->name->toLowerString();
            if ($constantName === 'null') {
                continue;
            }
            $optionalParameter = $parameterName;
        }
        return $errors;
    }
    /**
     * @param string $parameterName
     * @param Param[] $parameterNodes
     * @return Param
     */
    private function getParameterNode(string $parameterName, array $parameterNodes) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param
    {
        foreach ($parameterNodes as $param) {
            if ($param->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Error) {
                continue;
            }
            if (!\is_string($param->var->name)) {
                continue;
            }
            if ($param->var->name === $parameterName) {
                return $param;
            }
        }
        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException(\sprintf('Parameter %s not found.', $parameterName));
    }
    /**
     * @param \PHPStan\Reflection\ParameterReflection $parameter
     * @return string[]
     */
    private function getParameterReferencedClasses(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflection $parameter) : array
    {
        if (!$parameter instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
            return $parameter->getType()->getReferencedClasses();
        }
        if ($this->checkThisOnly) {
            return $parameter->getNativeType()->getReferencedClasses();
        }
        return \array_merge($parameter->getNativeType()->getReferencedClasses(), $parameter->getPhpDocType()->getReferencedClasses());
    }
    /**
     * @param \PHPStan\Reflection\ParametersAcceptor $parametersAcceptor
     * @return string[]
     */
    private function getReturnTypeReferencedClasses(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptor $parametersAcceptor) : array
    {
        if (!$parametersAcceptor instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\ParametersAcceptorWithPhpDocs) {
            return $parametersAcceptor->getReturnType()->getReferencedClasses();
        }
        if ($this->checkThisOnly) {
            return $parametersAcceptor->getNativeReturnType()->getReferencedClasses();
        }
        return \array_merge($parametersAcceptor->getNativeReturnType()->getReferencedClasses(), $parametersAcceptor->getPhpDocReturnType()->getReferencedClasses());
    }
}
