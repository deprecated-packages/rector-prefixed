<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby;

use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\NullableType;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var string[][]
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication', '_PhpScopere8e811afab72\\Nette\\Application\\IPresenter' => 'getPresenter'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication', '_PhpScopere8e811afab72\\Nette\\Application\\Request' => 'getRequest'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\Application' => 'getApplication', '_PhpScopere8e811afab72\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\IPresenter' => 'getPresenter', '_PhpScopere8e811afab72\\Nette\\Application\\IResponse' => 'getResponse'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['_PhpScopere8e811afab72\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['_PhpScopere8e811afab72\\Nette\\Security\\User' => 'getUser'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['_PhpScopere8e811afab72\\Nette\\Security\\User' => 'getUser'],
        // latte
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['_PhpScopere8e811afab72\\Latte\\Engine' => 'getEngine'],
        '_PhpScopere8e811afab72\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['_PhpScopere8e811afab72\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
    ];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var VariableNaming
     */
    private $variableNaming;
    /**
     * @var StaticTypeMapper
     */
    private $staticTypeMapper;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScopere8e811afab72\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \_PhpScopere8e811afab72\PhpParser\Node\Param $param, ?\_PhpScopere8e811afab72\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : string
    {
        $getterMethodsWithType = self::CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE[$eventClass] ?? null;
        $paramType = $param->type;
        // unwrap nullable type
        if ($paramType instanceof \_PhpScopere8e811afab72\PhpParser\Node\NullableType) {
            $paramType = $paramType->type;
        }
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if (!$getterMethodBlueprint->getReturnTypeNode() instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
                    continue;
                }
                if ($this->betterStandardPrinter->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        if ($paramType === null || $paramType instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            if ($paramType === null) {
                $staticType = new \_PhpScopere8e811afab72\PHPStan\Type\MixedType();
            } else {
                $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
            }
            return $this->createGetterFromParamAndStaticType($param, $staticType);
        }
        $type = $this->nodeNameResolver->getName($paramType);
        if ($type === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        // system contribute event
        if (isset($getterMethodsWithType[$type])) {
            return $getterMethodsWithType[$type];
        }
        $paramName = $this->nodeNameResolver->getName($param->var);
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if ($getterMethodBlueprint->getVariableName() === $paramName) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
        return $this->createGetterFromParamAndStaticType($param, $staticType);
    }
    private function createGetterFromParamAndStaticType(\_PhpScopere8e811afab72\PhpParser\Node\Param $param, \_PhpScopere8e811afab72\PHPStan\Type\Type $type) : string
    {
        $variableName = $this->variableNaming->resolveFromNodeAndType($param, $type);
        if ($variableName === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return 'get' . \ucfirst($variableName);
    }
}
