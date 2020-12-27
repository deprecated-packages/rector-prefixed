<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Testing;

use RectorPrefix20201227\Composer\Autoload\ClassLoader;
use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\FunctionReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Ast\Locator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
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
    public function __construct(\RectorPrefix20201227\PHPStan\DependencyInjection\Container $container, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker $composerJsonAndInstalledJsonSourceLocatorMaker, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator $autoloadSourceLocator, \PhpParser\Parser $phpParser, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpstormStubsSourceStubber, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber $reflectionSourceStubber)
    {
        $this->container = $container;
        $this->composerJsonAndInstalledJsonSourceLocatorMaker = $composerJsonAndInstalledJsonSourceLocatorMaker;
        $this->autoloadSourceLocator = $autoloadSourceLocator;
        $this->phpParser = $phpParser;
        $this->phpstormStubsSourceStubber = $phpstormStubsSourceStubber;
        $this->reflectionSourceStubber = $reflectionSourceStubber;
    }
    public function create() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $classLoaderReflection = new \ReflectionClass(\RectorPrefix20201227\Composer\Autoload\ClassLoader::class);
        if ($classLoaderReflection->getFileName() === \false) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException('Unknown ClassLoader filename');
        }
        $composerProjectPath = \dirname($classLoaderReflection->getFileName(), 3);
        if (!\is_file($composerProjectPath . '/composer.json')) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException(\sprintf('composer.json not found in directory %s', $composerProjectPath));
        }
        $composerSourceLocator = $this->composerJsonAndInstalledJsonSourceLocatorMaker->create($composerProjectPath);
        if ($composerSourceLocator === null) {
            throw new \RectorPrefix20201227\PHPStan\ShouldNotHappenException('Could not create composer source locator');
        }
        $locators = [$composerSourceLocator];
        $astLocator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Ast\Locator($this->phpParser, function () : FunctionReflector {
            return $this->container->getService('testCaseFunctionReflector');
        });
        $locators[] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpstormStubsSourceStubber);
        $locators[] = $this->autoloadSourceLocator;
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        return new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
