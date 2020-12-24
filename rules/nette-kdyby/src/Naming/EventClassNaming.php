<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteKdyby\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class EventClassNaming
{
    /**
     * @var string
     */
    private const EVENT = 'Event';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * "App\SomeNamespace\SomeClass::onUpload"
     * ↓
     * "App\SomeNamespace\Event\SomeClassUploadEvent"
     */
    public function createEventClassNameFromMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->prependShortClassEventWithNamespace($shortEventClassName, $className);
    }
    public function resolveEventFileLocationFromMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        return $fileInfo->getPath() . \DIRECTORY_SEPARATOR . self::EVENT . \DIRECTORY_SEPARATOR . $shortEventClassName . '.php';
    }
    public function resolveEventFileLocationFromClassNameAndFileInfo(string $className, \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
    {
        $shortClassName = $this->classNaming->getShortName($className);
        return $smartFileInfo->getPath() . \DIRECTORY_SEPARATOR . self::EVENT . \DIRECTORY_SEPARATOR . $shortClassName . '.php';
    }
    public function createEventClassNameFromClassAndProperty(string $className, string $methodName) : string
    {
        $shortEventClass = $this->createShortEventClassNameFromClassAndProperty($className, $methodName);
        return $this->prependShortClassEventWithNamespace($shortEventClass, $className);
    }
    public function createEventClassNameFromClassPropertyReference(string $classAndPropertyName) : string
    {
        [$class, $property] = \explode('::', $classAndPropertyName);
        $shortEventClass = $this->createShortEventClassNameFromClassAndProperty($class, $property);
        return $this->prependShortClassEventWithNamespace($shortEventClass, $class);
    }
    private function getShortEventClassName(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->createShortEventClassNameFromClassAndProperty($className, $methodName);
    }
    private function prependShortClassEventWithNamespace(string $shortEventClassName, string $orinalClassName) : string
    {
        $namespaceAbove = \_PhpScopere8e811afab72\Nette\Utils\Strings::before($orinalClassName, '\\', -1);
        return $namespaceAbove . '\\Event\\' . $shortEventClassName;
    }
    /**
     * TomatoMarket, onBuy
     * ↓
     * TomatoMarketBuyEvent
     */
    private function createShortEventClassNameFromClassAndProperty(string $class, string $property) : string
    {
        $shortClassName = $this->classNaming->getShortName($class);
        // "onMagic" => "Magic"
        $shortPropertyName = \_PhpScopere8e811afab72\Nette\Utils\Strings::substring($property, \strlen('on'));
        return $shortClassName . $shortPropertyName . self::EVENT;
    }
}
