<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Testing;

use _PhpScopere8e811afab72\Composer\Autoload\ClassLoader;
use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class TestCaseSourceLocatorFactory
{
    /** @var Container */
    private $container;
    /** @var ComposerJsonAndInstalledJsonSourceLocatorMaker */
    private $composerJsonAndInstalledJsonSourceLocatorMaker;
    /** @var AutoloadSourceLocator */
    private $autoloadSourceLocator;
    /** @var \PhpParser\Parser */
    private $phpParser;
    /** @var PhpStormStubsSourceStubber */
    private $phpstormStubsSourceStubber;
    /** @var ReflectionSourceStubber */
    private $reflectionSourceStubber;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container, \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker $composerJsonAndInstalledJsonSourceLocatorMaker, \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator $autoloadSourceLocator, \_PhpScopere8e811afab72\PhpParser\Parser $phpParser, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpstormStubsSourceStubber, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber $reflectionSourceStubber)
    {
        $this->container = $container;
        $this->composerJsonAndInstalledJsonSourceLocatorMaker = $composerJsonAndInstalledJsonSourceLocatorMaker;
        $this->autoloadSourceLocator = $autoloadSourceLocator;
        $this->phpParser = $phpParser;
        $this->phpstormStubsSourceStubber = $phpstormStubsSourceStubber;
        $this->reflectionSourceStubber = $reflectionSourceStubber;
    }
    public function create() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $classLoaderReflection = new \ReflectionClass(\_PhpScopere8e811afab72\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerSourceLocator = $this->composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            throw new \_PhpScopere8e811afab72\PHPStan\ShouldNotHappenException('Could not create composer source locator');
        }
        $locators = [$composerSourceLocator];
        $astLocator = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->phpParser, function () : FunctionReflector {
            return $this->container->getService('testCaseFunctionReflector');
        });
        $locators[] = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpstormStubsSourceStubber);
        $locators[] = $this->autoloadSourceLocator;
        $locators[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        $locators[] = new \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
