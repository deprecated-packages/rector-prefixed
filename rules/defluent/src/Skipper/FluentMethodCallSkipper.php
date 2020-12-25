<?php

declare (strict_types=1);
namespace Rector\Defluent\Skipper;

use PhpParser\Node\Expr\MethodCall;
use Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver;
use Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer;
use Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use Rector\Defluent\ValueObject\AssignAndRootExpr;
use Rector\Defluent\ValueObject\FirstAssignFluentCall;
final class FluentMethodCallSkipper
{
    /**
     * Skip query and builder
     * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/ "When does a fluent interface make sense?
     *
     * @var string[]
     */
    private const ALLOWED_FLUENT_TYPES = ['_PhpScoper567b66d83109\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\AbstractConfigurator', '_PhpScoper567b66d83109\\Nette\\Forms\\Controls\\BaseControl', '_PhpScoper567b66d83109\\Nette\\DI\\ContainerBuilder', '_PhpScoper567b66d83109\\Nette\\DI\\Definitions\\Definition', '_PhpScoper567b66d83109\\Nette\\DI\\Definitions\\ServiceDefinition', 'PHPStan\\Analyser\\Scope', 'DateTime', '_PhpScoper567b66d83109\\Nette\\Utils\\DateTime', 'DateTimeInterface', '*Finder', '*Builder', '*Query'];
    /**
     * @var FluentCallStaticTypeResolver
     */
    private $fluentCallStaticTypeResolver;
    /**
     * @var SameClassMethodCallAnalyzer
     */
    private $sameClassMethodCallAnalyzer;
    /**
     * @var FluentChainMethodCallNodeAnalyzer
     */
    private $fluentChainMethodCallNodeAnalyzer;
    /**
     * @var GetterMethodCallAnalyzer
     */
    private $getterMethodCallAnalyzer;
    /**
     * @var StringMatcher
     */
    private $stringMatcher;
    public function __construct(\Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver $fluentCallStaticTypeResolver, \Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer, \Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer $getterMethodCallAnalyzer, \Rector\Defluent\Skipper\StringMatcher $stringMatcher)
    {
        $this->fluentCallStaticTypeResolver = $fluentCallStaticTypeResolver;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->getterMethodCallAnalyzer = $getterMethodCallAnalyzer;
        $this->stringMatcher = $stringMatcher;
    }
    public function shouldSkipRootMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($methodCall)) {
            return \true;
        }
        return $this->getterMethodCallAnalyzer->isGetterMethodCall($methodCall);
    }
    public function shouldSkipFirstAssignFluentCall(\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall) : bool
    {
        $calleeUniqueTypes = $this->fluentCallStaticTypeResolver->resolveCalleeUniqueTypes($firstAssignFluentCall->getFluentMethodCalls());
        if (!$this->sameClassMethodCallAnalyzer->isCorrectTypeCount($calleeUniqueTypes, $firstAssignFluentCall)) {
            return \true;
        }
        $calleeUniqueType = $this->resolveCalleeUniqueType($firstAssignFluentCall, $calleeUniqueTypes);
        return $this->stringMatcher->isAllowedType($calleeUniqueType, self::ALLOWED_FLUENT_TYPES);
    }
    /**
     * @param MethodCall[] $fluentMethodCalls
     */
    public function shouldSkipMethodCalls(\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $fluentMethodCalls) : bool
    {
        $calleeUniqueTypes = $this->fluentCallStaticTypeResolver->resolveCalleeUniqueTypes($fluentMethodCalls);
        if (!$this->sameClassMethodCallAnalyzer->isCorrectTypeCount($calleeUniqueTypes, $assignAndRootExpr)) {
            return \true;
        }
        $calleeUniqueType = $this->resolveCalleeUniqueType($assignAndRootExpr, $calleeUniqueTypes);
        return $this->stringMatcher->isAllowedType($calleeUniqueType, self::ALLOWED_FLUENT_TYPES);
    }
    /**
     * @param string[] $calleeUniqueTypes
     */
    private function resolveCalleeUniqueType(\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface $firstCallFactoryAware, array $calleeUniqueTypes) : string
    {
        if (!$firstCallFactoryAware->isFirstCallFactory()) {
            return $calleeUniqueTypes[0];
        }
        return $calleeUniqueTypes[1] ?? $calleeUniqueTypes[0];
    }
}
