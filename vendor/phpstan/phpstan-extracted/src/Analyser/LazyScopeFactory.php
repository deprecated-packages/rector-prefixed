<?php

declare (strict_types=1);
namespace PHPStan\Analyser;

use PhpParser\PrettyPrinter\Standard;
use PHPStan\DependencyInjection\Container;
use PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\Reflection\ParametersAcceptor;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\Type;
class LazyScopeFactory implements \PHPStan\Analyser\ScopeFactory
{
    /** @var string */
    private $scopeClass;
    /** @var Container */
    private $container;
    /** @var string[] */
    private $dynamicConstantNames;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(string $scopeClass, \PHPStan\DependencyInjection\Container $container)
    {
        $this->scopeClass = $scopeClass;
        $this->container = $container;
        $this->dynamicConstantNames = $container->getParameter('dynamicConstantNames');
        $this->treatPhpDocTypesAsCertain = $container->getParameter('treatPhpDocTypesAsCertain');
    }
    /**
     * @param \PHPStan\Analyser\ScopeContext $context
     * @param bool $declareStrictTypes
     * @param array<string, Type> $constantTypes
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
    public function create(\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\PHPStan\Analyser\Scope $parentScope = null) : \PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->container->getByType(\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\PhpParser\PrettyPrinter\Standard::class), $this->container->getByType(\PHPStan\Analyser\TypeSpecifier::class), $this->container->getByType(\PHPStan\Rules\Properties\PropertyReflectionFinder::class), $this->container->getByType(\PHPStan\Parser\Parser::class), $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $afterExtractCall, $parentScope);
    }
}
