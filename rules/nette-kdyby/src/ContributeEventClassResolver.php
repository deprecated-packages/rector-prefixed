<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby;

use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\NullableType;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PHPStan\Type\MixedType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming\VariableNaming;
use _PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var string[][]
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperb75b35f52b74\\Nette\\Application\\IPresenter' => 'getPresenter'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperb75b35f52b74\\Nette\\Application\\Request' => 'getRequest'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\Application' => 'getApplication', '_PhpScoperb75b35f52b74\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\IPresenter' => 'getPresenter', '_PhpScoperb75b35f52b74\\Nette\\Application\\IResponse' => 'getResponse'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Security\\User' => 'getUser'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Security\\User' => 'getUser'],
        // latte
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['_PhpScoperb75b35f52b74\\Latte\\Engine' => 'getEngine'],
        '_PhpScoperb75b35f52b74\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['_PhpScoperb75b35f52b74\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoperb75b35f52b74\Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \_PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming\VariableNaming $variableNaming)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, ?\_PhpScoperb75b35f52b74\Rector\NetteKdyby\ValueObject\EventAndListenerTree $eventAndListenerTree = null) : string
    {
        $getterMethodsWithType = self::CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE[$eventClass] ?? null;
        $paramType = $param->type;
        // unwrap nullable type
        if ($paramType instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\NullableType) {
            $paramType = $paramType->type;
        }
        if ($eventAndListenerTree !== null) {
            $getterMethodBlueprints = $eventAndListenerTree->getGetterMethodBlueprints();
            foreach ($getterMethodBlueprints as $getterMethodBlueprint) {
                if (!$getterMethodBlueprint->getReturnTypeNode() instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Name) {
                    continue;
                }
                if ($this->betterStandardPrinter->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
                    return $getterMethodBlueprint->getMethodName();
                }
            }
        }
        if ($paramType === null || $paramType instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier) {
            if ($paramType === null) {
                $staticType = new \_PhpScoperb75b35f52b74\PHPStan\Type\MixedType();
            } else {
                $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($paramType);
            }
            return $this->createGetterFromParamAndStaticType($param, $staticType);
        }
        $type = $this->nodeNameResolver->getName($paramType);
        if ($type === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
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
    private function createGetterFromParamAndStaticType(\_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PHPStan\Type\Type $type) : string
    {
        $variableName = $this->variableNaming->resolveFromNodeAndType($param, $type);
        if ($variableName === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return 'get' . \ucfirst($variableName);
    }
}
