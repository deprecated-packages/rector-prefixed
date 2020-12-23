<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NetteKdyby\Naming;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * "App\SomeNamespace\SomeClass::onUpload"
     * ↓
     * "App\SomeNamespace\Event\SomeClassUploadEvent"
     */
    public function createEventClassNameFromMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->prependShortClassEventWithNamespace($shortEventClassName, $className);
    }
    public function resolveEventFileLocationFromMethodCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        return $fileInfo->getPath() . \DIRECTORY_SEPARATOR . self::EVENT . \DIRECTORY_SEPARATOR . $shortEventClassName . '.php';
    }
    public function resolveEventFileLocationFromClassNameAndFileInfo(string $className, \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
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
    private function getShortEventClassName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->createShortEventClassNameFromClassAndProperty($className, $methodName);
    }
    private function prependShortClassEventWithNamespace(string $shortEventClassName, string $orinalClassName) : string
    {
        $namespaceAbove = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::before($orinalClassName, '\\', -1);
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
        $shortPropertyName = \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::substring($property, \strlen('on'));
        return $shortClassName . $shortPropertyName . self::EVENT;
    }
}
