<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\NullableType;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PHPStan\Type\MixedType;
use _PhpScoper0a2ac50786fa\PHPStan\Type\Type;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var string[][]
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper0a2ac50786fa\\Nette\\Application\\IPresenter' => 'getPresenter'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper0a2ac50786fa\\Nette\\Application\\Request' => 'getRequest'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper0a2ac50786fa\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\IPresenter' => 'getPresenter', '_PhpScoper0a2ac50786fa\\Nette\\Application\\IResponse' => 'getResponse'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Security\\User' => 'getUser'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Security\\User' => 'getUser'],
        // latte
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['_PhpScoper0a2ac50786fa\\Latte\\Engine' => 'getEngine'],
        '_PhpScoper0a2ac50786fa\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['_PhpScoper0a2ac50786fa\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, ?\_PhpScoper0a2ac50786fa\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : string
    {
        $getterMethodsWithType = self::CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE[$eventClass] ?? null;
        $paramType = $param->type;
        // unwrap nullable type
        if ($paramType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\NullableType) {
            $paramType = $paramType->type;
        }
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if (!$getterMethodBlueprint->getReturnTypeNode() instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Name) {
                    continue;
                }
                if ($this->betterStandardPrinter->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        if ($paramType === null || $paramType instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
            if ($paramType === null) {
                $staticType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\MixedType();
            } else {
                $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
            }
            return $this->createGetterFromParamAndStaticType($param, $staticType);
        }
        $type = $this->nodeNameResolver->getName($paramType);
        if ($type === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
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
    private function createGetterFromParamAndStaticType(\_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, \_PhpScoper0a2ac50786fa\PHPStan\Type\Type $type) : string
    {
        $variableName = $this->variableNaming->resolveFromNodeAndType($param, $type);
        if ($variableName === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        return 'get' . \ucfirst($variableName);
    }
}
