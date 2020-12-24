<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Rules\Methods;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PHPStan\Analyser\Scope;
use _PhpScopere8e811afab72\PHPStan\Node\InClassMethodNode;
use _PhpScopere8e811afab72\PHPStan\Php\PhpVersion;
use _PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\MethodPrototypeReflection;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector;
use _PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection;
use _PhpScopere8e811afab72\PHPStan\Rules\Rule;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleError;
use _PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\IterableType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\PHPStan\Type\TypeCombinator;
use _PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel;
use function array_slice;
/**
 * @implements Rule<InClassMethodNode>
 */
class OverridingMethodRule implements \_PhpScopere8e811afab72\PHPStan\Rules\Rule
{
    /** @var PhpVersion */
    private $phpVersion;
    /** @var MethodSignatureRule */
    private $methodSignatureRule;
    /** @var bool */
    private $checkPhpDocMethodSignatures;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Php\PhpVersion $phpVersion, \_PhpScopere8e811afab72\PHPStan\Rules\Methods\MethodSignatureRule $methodSignatureRule, bool $checkPhpDocMethodSignatures)
    {
        $this->phpVersion = $phpVersion;
        $this->methodSignatureRule = $methodSignatureRule;
        $this->checkPhpDocMethodSignatures = $checkPhpDocMethodSignatures;
    }
    public function getNodeType() : string
    {
        return \_PhpScopere8e811afab72\PHPStan\Node\InClassMethodNode::class;
    }
    public function processNode(\_PhpScopere8e811afab72\PhpParser\Node $node, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        $method = $scope->getFunction();
        if (!$method instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\Php\PhpMethodFromParserNodeReflection) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        $prototype = $method->getPrototype();
        if ($prototype->getDeclaringClass()->getName() === $method->getDeclaringClass()->getName()) {
            if (\strtolower($method->getName()) === '__construct') {
                $parent = $method->getDeclaringClass()->getParentClass();
                if ($parent !== \false && $parent->hasConstructor()) {
                    $parentConstructor = $parent->getConstructor();
                    if ($parentConstructor->isFinal()->yes()) {
                        return $this->addErrors([\_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides final method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $parent->getDisplayName(), $parentConstructor->getName()))->nonIgnorable()->build()], $node, $scope);
                    }
                }
            }
            return [];
        }
        if (!$prototype instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\MethodPrototypeReflection) {
            return [];
        }
        $messages = [];
        if ($prototype->isFinal()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides final method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        if ($prototype->isStatic()) {
            if (!$method->isStatic()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Non-static method %s::%s() overrides static method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        } elseif ($method->isStatic()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Static method %s::%s() overrides non-static method %s::%s().', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        if ($prototype->isPublic()) {
            if (!$method->isPublic()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('%s method %s::%s() overriding public method %s::%s() should also be public.', $method->isPrivate() ? 'Private' : 'Protected', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        } elseif ($method->isPrivate()) {
            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Private method %s::%s() overriding protected method %s::%s() should be protected or public.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
        }
        $prototypeVariants = $prototype->getVariants();
        if (\count($prototypeVariants) !== 1) {
            return $this->addErrors($messages, $node, $scope);
        }
        $prototypeVariant = $prototypeVariants[0];
        $methodVariant = \_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptorSelector::selectSingle($method->getVariants());
        $methodParameters = $methodVariant->getParameters();
        $prototypeAfterVariadic = \false;
        foreach ($prototypeVariant->getParameters() as $i => $prototypeParameter) {
            if (!\array_key_exists($i, $methodParameters)) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Method %s::%s() overrides method %s::%s() but misses parameter #%d $%s.', $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName(), $i + 1, $prototypeParameter->getName()))->nonIgnorable()->build();
                continue;
            }
            $methodParameter = $methodParameters[$i];
            if ($prototypeParameter->passedByReference()->no()) {
                if (!$methodParameter->passedByReference()->no()) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is passed by reference but parameter #%d $%s of method %s::%s() is not passed by reference.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                }
            } elseif ($methodParameter->passedByReference()->no()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not passed by reference but parameter #%d $%s of method %s::%s() is passed by reference.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
            if ($prototypeParameter->isVariadic()) {
                $prototypeAfterVariadic = \true;
                if (!$methodParameter->isVariadic()) {
                    if (!$methodParameter->isOptional()) {
                        if (\count($methodParameters) !== $i + 1) {
                            $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not optional.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                            continue;
                        }
                        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic but parameter #%d $%s of method %s::%s() is variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                        continue;
                    } elseif (\count($methodParameters) === $i + 1) {
                        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                    }
                }
            } elseif ($methodParameter->isVariadic()) {
                if ($this->phpVersion->supportsLessOverridenParametersWithVariadic()) {
                    $remainingPrototypeParameters = \array_slice($prototypeVariant->getParameters(), $i);
                    foreach ($remainingPrototypeParameters as $j => $remainingPrototypeParameter) {
                        if (!$remainingPrototypeParameter instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
                            continue;
                        }
                        if ($methodParameter->getNativeType()->isSuperTypeOf($remainingPrototypeParameter->getNativeType())->yes()) {
                            continue;
                        }
                        $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d ...$%s (%s) of method %s::%s() is not contravariant with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameter->getNativeType()->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + $j + 1, $remainingPrototypeParameter->getName(), $remainingPrototypeParameter->getNativeType()->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                    }
                    break;
                }
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is variadic but parameter #%d $%s of method %s::%s() is not variadic.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                continue;
            }
            if ($prototypeParameter->isOptional() && !$methodParameter->isOptional()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is required but parameter #%d $%s of method %s::%s() is optional.', $i + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
            $methodParameterType = $methodParameter->getNativeType();
            if (!$prototypeParameter instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\ParameterReflectionWithPhpDocs) {
                continue;
            }
            $prototypeParameterType = $prototypeParameter->getNativeType();
            if (!$this->phpVersion->supportsParameterTypeWidening()) {
                if (!$methodParameterType->equals($prototypeParameterType)) {
                    $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() does not match parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
                }
                continue;
            }
            if ($this->isTypeCompatible($methodParameterType, $prototypeParameterType, $this->phpVersion->supportsParameterContravariance())) {
                continue;
            }
            if ($this->phpVersion->supportsParameterContravariance()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() is not contravariant with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            } else {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s (%s) of method %s::%s() is not compatible with parameter #%d $%s (%s) of method %s::%s().', $i + 1, $methodParameter->getName(), $methodParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $i + 1, $prototypeParameter->getName(), $prototypeParameterType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        }
        if (!isset($i)) {
            $i = -1;
        }
        foreach ($methodParameters as $j => $methodParameter) {
            if ($j <= $i) {
                continue;
            }
            if ($j === \count($methodParameters) - 1 && $prototypeAfterVariadic && !$methodParameter->isVariadic()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not variadic.', $j + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                continue;
            }
            if (!$methodParameter->isOptional()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Parameter #%d $%s of method %s::%s() is not optional.', $j + 1, $methodParameter->getName(), $method->getDeclaringClass()->getDisplayName(), $method->getName()))->nonIgnorable()->build();
                continue;
            }
        }
        $methodReturnType = $methodVariant->getNativeReturnType();
        if (!$prototypeVariant instanceof \_PhpScopere8e811afab72\PHPStan\Reflection\FunctionVariantWithPhpDocs) {
            return $this->addErrors($messages, $node, $scope);
        }
        $prototypeReturnType = $prototypeVariant->getNativeReturnType();
        if (!$this->isTypeCompatible($prototypeReturnType, $methodReturnType, $this->phpVersion->supportsReturnCovariance())) {
            if ($this->phpVersion->supportsReturnCovariance()) {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type %s of method %s::%s() is not covariant with return type %s of method %s::%s().', $methodReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototypeReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            } else {
                $messages[] = \_PhpScopere8e811afab72\PHPStan\Rules\RuleErrorBuilder::message(\sprintf('Return type %s of method %s::%s() is not compatible with return type %s of method %s::%s().', $methodReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $method->getDeclaringClass()->getDisplayName(), $method->getName(), $prototypeReturnType->describe(\_PhpScopere8e811afab72\PHPStan\Type\VerbosityLevel::typeOnly()), $prototype->getDeclaringClass()->getDisplayName(), $prototype->getName()))->nonIgnorable()->build();
            }
        }
        return $this->addErrors($messages, $node, $scope);
    }
    private function isTypeCompatible(\_PhpScopere8e811afab72\PHPStan\Type\Type $methodParameterType, \_PhpScopere8e811afab72\PHPStan\Type\Type $prototypeParameterType, bool $supportsContravariance) : bool
    {
        if ($methodParameterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            return \true;
        }
        if (!$supportsContravariance) {
            if (\_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::containsNull($methodParameterType)) {
                $prototypeParameterType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::removeNull($prototypeParameterType);
            }
            $methodParameterType = \_PhpScopere8e811afab72\PHPStan\Type\TypeCombinator::removeNull($methodParameterType);
            if ($methodParameterType->equals($prototypeParameterType)) {
                return \true;
            }
            if ($methodParameterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\IterableType) {
                if ($prototypeParameterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ArrayType) {
                    return \true;
                }
                if ($prototypeParameterType instanceof \_PhpScopere8e811afab72\PHPStan\Type\ObjectType && $prototypeParameterType->getClassName() === \Traversable::class) {
                    return \true;
                }
            }
            return \false;
        }
        return $methodParameterType->isSuperTypeOf($prototypeParameterType)->yes();
    }
    /**
     * @param RuleError[] $errors
     * @return (string|RuleError)[]
     */
    private function addErrors(array $errors, \_PhpScopere8e811afab72\PHPStan\Node\InClassMethodNode $classMethod, \_PhpScopere8e811afab72\PHPStan\Analyser\Scope $scope) : array
    {
        if (\count($errors) > 0) {
            return $errors;
        }
        if (!$this->checkPhpDocMethodSignatures) {
            return $errors;
        }
        return $this->methodSignatureRule->processNode($classMethod, $scope);
    }
}
