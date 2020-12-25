<?php

declare (strict_types=1);
namespace Rector\NetteKdyby;

use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\NetteKdyby\Naming\VariableNaming;
use Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var string[][]
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperf18a0c41e2d2\\Nette\\Application\\IPresenter' => 'getPresenter'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperf18a0c41e2d2\\Nette\\Application\\Request' => 'getRequest'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperf18a0c41e2d2\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\IPresenter' => 'getPresenter', '_PhpScoperf18a0c41e2d2\\Nette\\Application\\IResponse' => 'getResponse'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Security\\User' => 'getUser'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Security\\User' => 'getUser'],
        // latte
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['_PhpScoperf18a0c41e2d2\\Latte\\Engine' => 'getEngine'],
        '_PhpScoperf18a0c41e2d2\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['_PhpScoperf18a0c41e2d2\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
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
    public function __construct(\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \PhpParser\Node\Param $param, ?\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : string
    {
        $getterMethodsWithType = self::CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE[$eventClass] ?? null;
        $paramType = $param->type;
        // unwrap nullable type
        if ($paramType instanceof \PhpParser\Node\NullableType) {
            $paramType = $paramType->type;
        }
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if (!$getterMethodBlueprint->getReturnTypeNode() instanceof \PhpParser\Node\Name) {
                    continue;
                }
                if ($this->betterStandardPrinter->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        if ($paramType === null || $paramType instanceof \PhpParser\Node\Identifier) {
            if ($paramType === null) {
                $staticType = new \PHPStan\Type\MixedType();
            } else {
                $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
            }
            return $this->createGetterFromParamAndStaticType($param, $staticType);
        }
        $type = $this->nodeNameResolver->getName($paramType);
        if ($type === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
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
    private function createGetterFromParamAndStaticType(\PhpParser\Node\Param $param, \PHPStan\Type\Type $type) : string
    {
        $variableName = $this->variableNaming->resolveFromNodeAndType($param, $type);
        if ($variableName === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return 'get' . \ucfirst($variableName);
    }
}
