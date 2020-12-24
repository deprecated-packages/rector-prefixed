<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Analyser;

use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor;
use _PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider;
use _PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
/**
 * @internal
 */
class DirectScopeFactory implements \_PhpScopere8e811afab72\PHPStan\Analyser\ScopeFactory
{
    /** @var string */
    private $scopeClass;
    /** @var \PHPStan\Reflection\ReflectionProvider */
    private $reflectionProvider;
    /** @var \PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider */
    private $dynamicReturnTypeExtensionRegistryProvider;
    /** @var OperatorTypeSpecifyingExtensionRegistryProvider */
    private $operatorTypeSpecifyingExtensionRegistryProvider;
    /** @var \PhpParser\PrettyPrinter\Standard */
    private $printer;
    /** @var \PHPStan\Analyser\TypeSpecifier */
    private $typeSpecifier;
    /** @var \PHPStan\Rules\Properties\PropertyReflectionFinder */
    private $propertyReflectionFinder;
    /** @var \PHPStan\Parser\Parser */
    private $parser;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    /** @var string[] */
    private $dynamicConstantNames;
    public function __construct(string $scopeClass, \_PhpScopere8e811afab72\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, \_PhpScopere8e811afab72\PhpParser\PrettyPrinter\Standard $printer, \_PhpScopere8e811afab72\PHPStan\Analyser\TypeSpecifier $typeSpecifier, \_PhpScopere8e811afab72\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \_PhpScopere8e811afab72\PHPStan\Parser\Parser $parser, bool $treatPhpDocTypesAsCertain, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container)
    {
        $this->scopeClass = $scopeClass;
        $this->reflectionProvider = $reflectionProvider;
        $this->dynamicReturnTypeExtensionRegistryProvider = $dynamicReturnTypeExtensionRegistryProvider;
        $this->operatorTypeSpecifyingExtensionRegistryProvider = $operatorTypeSpecifyingExtensionRegistryProvider;
        $this->printer = $printer;
        $this->typeSpecifier = $typeSpecifier;
        $this->propertyReflectionFinder = $propertyReflectionFinder;
        $this->parser = $parser;
        $this->treatPhpDocTypesAsCertain = $treatPhpDocTypesAsCertain;
        $this->dynamicConstantNames = $container->getParameter('dynamicConstantNames');
    }
    /**
     * @param \PHPStan\Analyser\ScopeContext $context
     * @param bool $declareStrictTypes
     * @param  array<string, Type> $constantTypes
     * @param \PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection|null $function
     * @param string|null $namespace
     * @param \PHPStan\Analyser\VariableTypeHolder[] $variablesTypes
     * @param \PHPStan\Analyser\VariableTypeHolder[] $moreSpecificTypes
     * @param array<string, ConditionalExpressionHolder[]> $conditionalExpressions
     * @param string|null $inClosureBindScopeClass
     * @param \PHPStan\Reflection\ParametersAcceptor|null $anonymousFunctionReflection
     * @param bool $inFirstLevelStatement
     * @param array<string, true> $currentlyAssignedExpressions
     * @param array<string, Type> $nativeExpressionTypes
     * @param array<\PHPStan\Reflection\FunctionReflection|\PHPStan\Reflection\MethodReflection> $inFunctionCallsStack
     * @param bool $afterExtractCall
     * @param Scope|null $parentScope
     *
     * @return MutatingScope
     */
    public function create(\_PhpScopere8e811afab72\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\_PhpScopere8e811afab72\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\_PhpScopere8e811afab72\PHPStan\Analyser\Scope $parentScope = null) : \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \_PhpScopere8e811afab72\PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->reflectionProvider, $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry(), $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry(), $this->printer, $this->typeSpecifier, $this->propertyReflectionFinder, $this->parser, $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $afterExtractCall, $parentScope);
    }
}
