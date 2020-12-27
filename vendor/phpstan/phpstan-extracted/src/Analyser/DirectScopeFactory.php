<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\Type;
/**
 * @internal
 */
class DirectScopeFactory implements \RectorPrefix20201227\PHPStan\Analyser\ScopeFactory
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
    public function __construct(string $scopeClass, \RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, \PhpParser\PrettyPrinter\Standard $printer, \RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier $typeSpecifier, \RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \RectorPrefix20201227\PHPStan\Parser\Parser $parser, bool $treatPhpDocTypesAsCertain, \RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
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
    public function create(\RectorPrefix20201227\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $parentScope = null) : \RectorPrefix20201227\PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \RectorPrefix20201227\PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->reflectionProvider, $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry(), $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry(), $this->printer, $this->typeSpecifier, $this->propertyReflectionFinder, $this->parser, $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $afterExtractCall, $parentScope);
    }
}
