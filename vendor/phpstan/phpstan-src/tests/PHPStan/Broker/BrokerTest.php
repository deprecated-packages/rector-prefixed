<?php

declare (strict_types=1);
namespace PHPStan\Broker;

use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Cache\Cache;
use PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider;
use PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider;
use PHPStan\File\FileHelper;
use PHPStan\File\SimpleRelativePathHelper;
use PHPStan\Php\PhpVersion;
use PHPStan\PhpDoc\PhpDocNodeResolver;
use PHPStan\PhpDoc\PhpDocStringResolver;
use PHPStan\PhpDoc\StubPhpDocProvider;
use PHPStan\Reflection\FunctionReflectionFactory;
use PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider;
use PHPStan\Reflection\Runtime\RuntimeReflectionProvider;
use PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider;
use PHPStan\Type\FileTypeMapper;
use _PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
class BrokerTest extends \PHPStan\Testing\TestCase
{
    /** @var \PHPStan\Broker\Broker */
    private $broker;
    protected function setUp() : void
    {
        $phpDocStringResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocStringResolver::class);
        $phpDocNodeResolver = self::getContainer()->getByType(\PHPStan\PhpDoc\PhpDocNodeResolver::class);
        $workingDirectory = __DIR__;
        $relativePathHelper = new \PHPStan\File\SimpleRelativePathHelper($workingDirectory);
        $fileHelper = new \PHPStan\File\FileHelper($workingDirectory);
        $anonymousClassNameHelper = new \PHPStan\Broker\AnonymousClassNameHelper($fileHelper, $relativePathHelper);
        $classReflectionExtensionRegistryProvider = new \PHPStan\DependencyInjection\Reflection\DirectClassReflectionExtensionRegistryProvider([], []);
        $dynamicReturnTypeExtensionRegistryProvider = new \PHPStan\DependencyInjection\Type\DirectDynamicReturnTypeExtensionRegistryProvider([], [], []);
        $operatorTypeSpecifyingExtensionRegistryProvider = new \PHPStan\DependencyInjection\Type\DirectOperatorTypeSpecifyingExtensionRegistryProvider([]);
        $setterReflectionProviderProvider = new \PHPStan\Reflection\ReflectionProvider\SetterReflectionProviderProvider();
        $reflectionProvider = new \PHPStan\Reflection\Runtime\RuntimeReflectionProvider($setterReflectionProviderProvider, $classReflectionExtensionRegistryProvider, $this->createMock(\PHPStan\Reflection\FunctionReflectionFactory::class), new \PHPStan\Type\FileTypeMapper($setterReflectionProviderProvider, $this->getParser(), $phpDocStringResolver, $phpDocNodeResolver, $this->createMock(\PHPStan\Cache\Cache::class), $anonymousClassNameHelper), self::getContainer()->getByType(\PHPStan\Php\PhpVersion::class), self::getContainer()->getByType(\PHPStan\Reflection\SignatureMap\NativeFunctionReflectionProvider::class), self::getContainer()->getByType(\PHPStan\PhpDoc\StubPhpDocProvider::class), self::getContainer()->getByType(\_PhpScoper88fe6e0ad041\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber::class));
        $setterReflectionProviderProvider->setReflectionProvider($reflectionProvider);
        $this->broker = new \PHPStan\Broker\Broker($reflectionProvider, $dynamicReturnTypeExtensionRegistryProvider, $operatorTypeSpecifyingExtensionRegistryProvider, []);
        $classReflectionExtensionRegistryProvider->setBroker($this->broker);
        $dynamicReturnTypeExtensionRegistryProvider->setBroker($this->broker);
        $operatorTypeSpecifyingExtensionRegistryProvider->setBroker($this->broker);
    }
    public function testClassNotFound() : void
    {
        $this->expectException(\PHPStan\Broker\ClassNotFoundException::class);
        $this->expectExceptionMessage('NonexistentClass');
        $this->broker->getClass('NonexistentClass');
    }
    public function testFunctionNotFound() : void
    {
        $this->expectException(\PHPStan\Broker\FunctionNotFoundException::class);
        $this->expectExceptionMessage('Function nonexistentFunction not found while trying to analyse it - discovering symbols is probably not configured properly.');
        $scope = $this->createMock(\PHPStan\Analyser\Scope::class);
        $scope->method('getNamespace')->willReturn(null);
        $this->broker->getFunction(new \PhpParser\Node\Name('nonexistentFunction'), $scope);
    }
    public function testClassAutoloadingException() : void
    {
        $this->expectException(\PHPStan\Broker\ClassAutoloadingException::class);
        $this->expectExceptionMessage('thrown while looking for class NonexistentClass.');
        \spl_autoload_register(static function () : void {
            require_once __DIR__ . '/../Analyser/data/parse-error.php';
        }, \true, \true);
        $this->broker->hasClass('NonexistentClass');
    }
}
