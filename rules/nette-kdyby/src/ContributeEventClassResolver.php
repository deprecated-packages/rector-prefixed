<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var string[][]
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\IPresenter' => 'getPresenter'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Request' => 'getRequest'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\Application' => 'getApplication', '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\IPresenter' => 'getPresenter', '_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\IResponse' => 'getResponse'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\User' => 'getUser'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Security\\User' => 'getUser'],
        // latte
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['_PhpScoper2a4e7ab1ecbc\\Latte\\Engine' => 'getEngine'],
        '_PhpScoper2a4e7ab1ecbc\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['_PhpScoper2a4e7ab1ecbc\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, ?\_PhpScoper2a4e7ab1ecbc\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : string
    {
        $getterMethodsWithType = self::CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE[$eventClass] ?? null;
        $paramType = $param->type;
        // unwrap nullable type
        if ($paramType instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\NullableType) {
            $paramType = $paramType->type;
        }
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if (!$getterMethodBlueprint->getReturnTypeNode() instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name) {
                    continue;
                }
                if ($this->betterStandardPrinter->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        if ($paramType === null || $paramType instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier) {
            if ($paramType === null) {
                $staticType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\MixedType();
            } else {
                $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
            }
            return $this->createGetterFromParamAndStaticType($param, $staticType);
        }
        $type = $this->nodeNameResolver->getName($paramType);
        if ($type === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
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
    private function createGetterFromParamAndStaticType(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Param $param, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type) : string
    {
        $variableName = $this->variableNaming->resolveFromNodeAndType($param, $type);
        if ($variableName === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        return 'get' . \ucfirst($variableName);
    }
}
