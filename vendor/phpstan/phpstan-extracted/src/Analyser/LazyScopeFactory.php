<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Analyser;

use PhpParser\PrettyPrinter\Standard;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider;
use RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor;
use RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider;
use RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder;
use PHPStan\Type\Type;
class LazyScopeFactory implements \RectorPrefix20201227\PHPStan\Analyser\ScopeFactory
{
    /** @var string */
    private $scopeClass;
    /** @var Container */
    private $container;
    /** @var string[] */
    private $dynamicConstantNames;
    /** @var bool */
    private $treatPhpDocTypesAsCertain;
    public function __construct(string $scopeClass, \RectorPrefix20201227\PHPStan\DependencyInjection\Container $container)
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
    public function create(\RectorPrefix20201227\PHPStan\Analyser\ScopeContext $context, bool $declareStrictTypes = \false, array $constantTypes = [], $function = null, ?string $namespace = null, array $variablesTypes = [], array $moreSpecificTypes = [], array $conditionalExpressions = [], ?string $inClosureBindScopeClass = null, ?\RectorPrefix20201227\PHPStan\Reflection\ParametersAcceptor $anonymousFunctionReflection = null, bool $inFirstLevelStatement = \true, array $currentlyAssignedExpressions = [], array $nativeExpressionTypes = [], array $inFunctionCallsStack = [], bool $afterExtractCall = \false, ?\RectorPrefix20201227\PHPStan\Analyser\Scope $parentScope = null) : \RectorPrefix20201227\PHPStan\Analyser\MutatingScope
    {
        $scopeClass = $this->scopeClass;
        if (!\is_a($scopeClass, \RectorPrefix20201227\PHPStan\Analyser\MutatingScope::class, \true)) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException();
        }
        return new $scopeClass($this, $this->container->getByType(\RectorPrefix20201227\PHPStan\Reflection\ReflectionProvider::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\DynamicReturnTypeExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\RectorPrefix20201227\PHPStan\DependencyInjection\Type\OperatorTypeSpecifyingExtensionRegistryProvider::class)->getRegistry(), $this->container->getByType(\PhpParser\PrettyPrinter\Standard::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\Analyser\TypeSpecifier::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\Rules\Properties\PropertyReflectionFinder::class), $this->container->getByType(\RectorPrefix20201227\PHPStan\Parser\Parser::class), $context, $declareStrictTypes, $constantTypes, $function, $namespace, $variablesTypes, $moreSpecificTypes, $conditionalExpressions, $inClosureBindScopeClass, $anonymousFunctionReflection, $inFirstLevelStatement, $currentlyAssignedExpressions, $nativeExpressionTypes, $inFunctionCallsStack, $this->dynamicConstantNames, $this->treatPhpDocTypesAsCertain, $afterExtractCall, $parentScope);
    }
}
