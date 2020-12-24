<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteKdyby\Naming;

use _PhpScoperb75b35f52b74\Nette\Utils\Strings;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    /**
     * "App\SomeNamespace\SomeClass::onUpload"
     * ↓
     * "App\SomeNamespace\Event\SomeClassUploadEvent"
     */
    public function createEventClassNameFromMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->prependShortClassEventWithNamespace($shortEventClassName, $className);
    }
    public function resolveEventFileLocationFromMethodCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $shortEventClassName = $this->getShortEventClassName($methodCall);
        /** @var SmartFileInfo $fileInfo */
        $fileInfo = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
        return $fileInfo->getPath() . \DIRECTORY_SEPARATOR . self::EVENT . \DIRECTORY_SEPARATOR . $shortEventClassName . '.php';
    }
    public function resolveEventFileLocationFromClassNameAndFileInfo(string $className, \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo) : string
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
    private function getShortEventClassName(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        /** @var string $methodName */
        $methodName = $this->nodeNameResolver->getName($methodCall->name);
        /** @var string $className */
        $className = $methodCall->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $this->createShortEventClassNameFromClassAndProperty($className, $methodName);
    }
    private function prependShortClassEventWithNamespace(string $shortEventClassName, string $orinalClassName) : string
    {
        $namespaceAbove = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::before($orinalClassName, '\\', -1);
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
        $shortPropertyName = \_PhpScoperb75b35f52b74\Nette\Utils\Strings::substring($property, \strlen('on'));
        return $shortClassName . $shortPropertyName . self::EVENT;
    }
}
