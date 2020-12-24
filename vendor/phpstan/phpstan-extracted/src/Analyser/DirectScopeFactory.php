<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Analyser;

use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use _PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor;
use _PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider;
use _PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
/**
 * @internal
 */
class DirectScopeFactory implements \_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeFactory
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
    public function __construct(string $scopeClass, \_PhpScoperb75b35f52b74\PHPStan\Reflection\ReflectionProvider $reflectionProvider, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider $dynamicReturnTypeExtensionRegistryProvider, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider $operatorTypeSpecifyingExtensionRegistryProvider, \_PhpScoperb75b35f52b74\PhpParser\PrettyPrinter\Standard $printer, \_PhpScoperb75b35f52b74\PHPStan\Analyser\TypeSpecifier $typeSpecifier, \_PhpScoperb75b35f52b74\PHPStan\Rules\Properties\PropertyReflectionFinder $propertyReflectionFinder, \_PhpScoperb75b35f52b74\PHPStan\Parser\Parser $parser, bool $treatPhpDocTypesAsCertain, \_PhpScoperb75b35f52b74\PHPStan\DependencyInjection\Container $container)
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
    public function create(\_PhpScoperb75b35f52b74\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\_PhpScoperb75b35f52b74\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\_PhpScoperb75b35f52b74\PHPStan\Analyser\Scope $parentScope = null) : \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \_PhpScoperb75b35f52b74\PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \_PhpScoperb75b35f52b74\PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->reflectionProvider, $this->dynamicReturnTypeExtensionRegistryProvider->getRegistry(), $this->operatorTypeSpecifyingExtensionRegistryProvider->getRegistry(), $this->printer, $this->typeSpecifier, $this->propertyReflectionFinder, $this->parser, $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $afterExtractCall, $parentScope);
    }
}
