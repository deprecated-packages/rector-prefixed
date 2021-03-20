<?php

declare (strict_types=1);
namespace Rector\Nette\Kdyby;

use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use PHPStan\Type\MixedType;
use PHPStan\Type\Type;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Comparing\NodeComparator;
use Rector\Naming\Naming\VariableNaming;
use Rector\Nette\Kdyby\ValueObject\EventAndListenerTree;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\StaticTypeMapper\StaticTypeMapper;
final class ContributeEventClassResolver
{
    /**
     * @var array<string, array<string, string>>
     */
    private const CONTRIBUTTE_EVENT_GETTER_METHODS_WITH_TYPE = [
        // application
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\ShutdownEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\StartupEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\ErrorEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication', 'Throwable' => 'getThrowable'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\PresenterEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication', 'RectorPrefix20210320\\Nette\\Application\\IPresenter' => 'getPresenter'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\RequestEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication', 'RectorPrefix20210320\\Nette\\Application\\Request' => 'getRequest'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\ResponseEvent' => ['RectorPrefix20210320\\Nette\\Application\\Application' => 'getApplication', 'RectorPrefix20210320\\Nette\\Application\\IResponse' => 'getResponse'],
        // presenter
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\PresenterShutdownEvent' => ['RectorPrefix20210320\\Nette\\Application\\IPresenter' => 'getPresenter', 'RectorPrefix20210320\\Nette\\Application\\IResponse' => 'getResponse'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Application\\PresenterStartupEvent' => ['RectorPrefix20210320\\Nette\\Application\\UI\\Presenter' => 'getPresenter'],
        // nette/security
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Security\\LoggedInEvent' => ['RectorPrefix20210320\\Nette\\Security\\User' => 'getUser'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Security\\LoggedOutEvent' => ['RectorPrefix20210320\\Nette\\Security\\User' => 'getUser'],
        // latte
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Latte\\LatteCompileEvent' => ['RectorPrefix20210320\\Latte\\Engine' => 'getEngine'],
        'RectorPrefix20210320\\Contributte\\Events\\Extra\\Event\\Latte\\TemplateCreateEvent' => ['RectorPrefix20210320\\Nette\\Bridges\\ApplicationLatte\\Template' => 'getTemplate'],
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
     * @var NodeComparator
     */
    private $nodeComparator;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Rector\StaticTypeMapper\StaticTypeMapper $staticTypeMapper, \Rector\Naming\Naming\VariableNaming $variableNaming, \Rector\Core\PhpParser\Comparing\NodeComparator $nodeComparator)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->variableNaming = $variableNaming;
        $this->staticTypeMapper = $staticTypeMapper;
        $this->nodeComparator = $nodeComparator;
    }
    public function resolveGetterMethodByEventClassAndParam(string $eventClass, \PhpParser\Node\Param $param, ?\Rector\Nette\Kdyby\ValueObject\EventAndListenerTree $eventAndListenerTree) : string
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
                if ($this->nodeComparator->areNodesEqual($getterMethodBlueprint->getReturnTypeNode(), $paramType)) {
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
