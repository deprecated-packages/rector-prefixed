<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Defluent\Skipper;

use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\AssignAndRootExpr;
use _PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall;
final class FluentMethodCallSkipper
{
    /**
     * Skip query and builder
     * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/ "When does a fluent interface make sense?
     *
     * @var string[]
     */
    private const ALLOWED_FLUENT_TYPES = ['_PhpScoper0a6b37af0871\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\AbstractConfigurator', '_PhpScoper0a6b37af0871\\Nette\\Forms\\Controls\\BaseControl', '_PhpScoper0a6b37af0871\\Nette\\DI\\ContainerBuilder', '_PhpScoper0a6b37af0871\\Nette\\DI\\Definitions\\Definition', '_PhpScoper0a6b37af0871\\Nette\\DI\\Definitions\\ServiceDefinition', '_PhpScoper0a6b37af0871\\PHPStan\\Analyser\\Scope', 'DateTime', '_PhpScoper0a6b37af0871\\Nette\\Utils\\DateTime', 'DateTimeInterface', '*Finder', '*Builder', '*Query'];
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver $fluentCallStaticTypeResolver, \_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer, \_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScoper0a6b37af0871\Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer $getterMethodCallAnalyzer, \_PhpScoper0a6b37af0871\Rector\Defluent\Skipper\StringMatcher $stringMatcher)
    {
        $this->fluentCallStaticTypeResolver = $fluentCallStaticTypeResolver;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->getterMethodCallAnalyzer = $getterMethodCallAnalyzer;
        $this->stringMatcher = $stringMatcher;
    }
    public function shouldSkipRootMethodCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($methodCall)) {
            return \true;
        }
        return $this->getterMethodCallAnalyzer->isGetterMethodCall($methodCall);
    }
    public function shouldSkipFirstAssignFluentCall(\_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall) : bool
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
    public function shouldSkipMethodCalls(\_PhpScoper0a6b37af0871\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $fluentMethodCalls) : bool
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
    private function resolveCalleeUniqueType(\_PhpScoper0a6b37af0871\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface $firstCallFactoryAware, array $calleeUniqueTypes) : string
    {
        if (!$firstCallFactoryAware->isFirstCallFactory()) {
            return $calleeUniqueTypes[0];
        }
        return $calleeUniqueTypes[1] ?? $calleeUniqueTypes[0];
    }
}
