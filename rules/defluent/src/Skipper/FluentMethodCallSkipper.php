<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Defluent\Skipper;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr;
use _PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall;
final class FluentMethodCallSkipper
{
    /**
     * Skip query and builder
     * @see https://ocramius.github.io/blog/fluent-interfaces-are-evil/ "When does a fluent interface make sense?
     *
     * @var string[]
     */
    private const ALLOWED_FLUENT_TYPES = ['_PhpScoperb75b35f52b74\\Symfony\\Component\\DependencyInjection\\Loader\\Configurator\\AbstractConfigurator', '_PhpScoperb75b35f52b74\\Nette\\Forms\\Controls\\BaseControl', '_PhpScoperb75b35f52b74\\Nette\\DI\\ContainerBuilder', '_PhpScoperb75b35f52b74\\Nette\\DI\\Definitions\\Definition', '_PhpScoperb75b35f52b74\\Nette\\DI\\Definitions\\ServiceDefinition', '_PhpScoperb75b35f52b74\\PHPStan\\Analyser\\Scope', 'DateTime', '_PhpScoperb75b35f52b74\\Nette\\Utils\\DateTime', 'DateTimeInterface', '*Finder', '*Builder', '*Query'];
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentCallStaticTypeResolver $fluentCallStaticTypeResolver, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\SameClassMethodCallAnalyzer $sameClassMethodCallAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\FluentChainMethodCallNodeAnalyzer $fluentChainMethodCallNodeAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\NodeAnalyzer\GetterMethodCallAnalyzer $getterMethodCallAnalyzer, \_PhpScoperb75b35f52b74\Rector\Defluent\Skipper\StringMatcher $stringMatcher)
    {
        $this->fluentCallStaticTypeResolver = $fluentCallStaticTypeResolver;
        $this->sameClassMethodCallAnalyzer = $sameClassMethodCallAnalyzer;
        $this->fluentChainMethodCallNodeAnalyzer = $fluentChainMethodCallNodeAnalyzer;
        $this->getterMethodCallAnalyzer = $getterMethodCallAnalyzer;
        $this->stringMatcher = $stringMatcher;
    }
    public function shouldSkipRootMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : bool
    {
        if (!$this->fluentChainMethodCallNodeAnalyzer->isLastChainMethodCall($methodCall)) {
            return \true;
        }
        return $this->getterMethodCallAnalyzer->isGetterMethodCall($methodCall);
    }
    public function shouldSkipFirstAssignFluentCall(\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\FirstAssignFluentCall $firstAssignFluentCall) : bool
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
    public function shouldSkipMethodCalls(\_PhpScoperb75b35f52b74\Rector\Defluent\ValueObject\AssignAndRootExpr $assignAndRootExpr, array $fluentMethodCalls) : bool
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
    private function resolveCalleeUniqueType(\_PhpScoperb75b35f52b74\Rector\Defluent\Contract\ValueObject\FirstCallFactoryAwareInterface $firstCallFactoryAware, array $calleeUniqueTypes) : string
    {
        if (!$firstCallFactoryAware->isFirstCallFactory()) {
            return $calleeUniqueTypes[0];
        }
        return $calleeUniqueTypes[1] ?? $calleeUniqueTypes[0];
    }
}
