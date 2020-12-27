<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Php\PhpVersion;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ClassBlacklistSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ClassWhitelistSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\SkipClassAliasSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class BetterReflectionSourceLocatorFactory
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var \PhpParser\Parser */
    private $php8Parser;
    /** @var PhpStormStubsSourceStubber */
    private $phpstormStubsSourceStubber;
    /** @var ReflectionSourceStubber */
    private $reflectionSourceStubber;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository */
    private $optimizedSingleFileSourceLocatorRepository;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository */
    private $optimizedDirectorySourceLocatorRepository;
    /** @var ComposerJsonAndInstalledJsonSourceLocatorMaker */
    private $composerJsonAndInstalledJsonSourceLocatorMaker;
    /** @var AutoloadSourceLocator */
    private $autoloadSourceLocator;
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var string[] */
    private $autoloadDirectories;
    /** @var string[] */
    private $autoloadFiles;
    /** @var string[] */
    private $scanFiles;
    /** @var string[] */
    private $scanDirectories;
    /** @var string[] */
    private $analysedPaths;
    /** @var string[] */
    private $composerAutoloaderProjectPaths;
    /** @var string[] */
    private $analysedPathsFromConfig;
    /** @var string|null */
    private $singleReflectionFile;
    /** @var string[] */
    private $staticReflectionClassNamePatterns;
    /**
     * @param string[] $autoloadDirectories
     * @param string[] $autoloadFiles
     * @param string[] $scanFiles
     * @param string[] $scanDirectories
     * @param string[] $analysedPaths
     * @param string[] $composerAutoloaderProjectPaths
     * @param string[] $analysedPathsFromConfig
     * @param string|null $singleReflectionFile,
     * @param string[] $staticReflectionClassNamePatterns
     */
    public function __construct(\PhpParser\Parser $parser, \PhpParser\Parser $php8Parser, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpstormStubsSourceStubber, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\ReflectionSourceStubber $reflectionSourceStubber, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedDirectorySourceLocatorRepository $optimizedDirectorySourceLocatorRepository, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ComposerJsonAndInstalledJsonSourceLocatorMaker $composerJsonAndInstalledJsonSourceLocatorMaker, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\AutoloadSourceLocator $autoloadSourceLocator, \RectorPrefix20201227\PHPStan\DependencyInjection\Container $container, array $autoloadDirectories, array $autoloadFiles, array $scanFiles, array $scanDirectories, array $analysedPaths, array $composerAutoloaderProjectPaths, array $analysedPathsFromConfig, ?string $singleReflectionFile, array $staticReflectionClassNamePatterns)
    {
        $this->parser = $parser;
        $this->php8Parser = $php8Parser;
        $this->phpstormStubsSourceStubber = $phpstormStubsSourceStubber;
        $this->reflectionSourceStubber = $reflectionSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->optimizedDirectorySourceLocatorRepository = $optimizedDirectorySourceLocatorRepository;
        $this->composerJsonAndInstalledJsonSourceLocatorMaker = $composerJsonAndInstalledJsonSourceLocatorMaker;
        $this->autoloadSourceLocator = $autoloadSourceLocator;
        $this->container = $container;
        $this->autoloadDirectories = $autoloadDirectories;
        $this->autoloadFiles = $autoloadFiles;
        $this->scanFiles = $scanFiles;
        $this->scanDirectories = $scanDirectories;
        $this->analysedPaths = $analysedPaths;
        $this->composerAutoloaderProjectPaths = $composerAutoloaderProjectPaths;
        $this->analysedPathsFromConfig = $analysedPathsFromConfig;
        $this->singleReflectionFile = $singleReflectionFile;
        $this->staticReflectionClassNamePatterns = $staticReflectionClassNamePatterns;
    }
    public function create() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        if ($this->singleReflectionFile !== null) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($this->singleReflectionFile);
        }
        $analysedDirectories = [];
        $analysedFiles = [];
        foreach (\array_merge($this->analysedPaths, $this->analysedPathsFromConfig) as $analysedPath) {
            if (\is_file($analysedPath)) {
                $analysedFiles[] = $analysedPath;
                continue;
            }
            if (!\is_dir($analysedPath)) {
                continue;
            }
            $analysedDirectories[] = $analysedPath;
        }
        $analysedFiles = \array_unique(\array_merge($analysedFiles, $this->autoloadFiles, $this->scanFiles));
        foreach ($analysedFiles as $analysedFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($analysedFile);
        }
        $directories = \array_unique(\array_merge($analysedDirectories, $this->autoloadDirectories, $this->scanDirectories));
        foreach ($directories as $directory) {
            $locators[] = $this->optimizedDirectorySourceLocatorRepository->getOrCreate($directory);
        }
        $astLocator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('betterReflectionFunctionReflector');
        });
        $astPhp8Locator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->php8Parser, function () : FunctionReflector {
            return $this->container->getService('betterReflectionFunctionReflector');
        });
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\SkipClassAliasSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astPhp8Locator, $this->phpstormStubsSourceStubber));
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ClassBlacklistSourceLocator($this->autoloadSourceLocator, $this->staticReflectionClassNamePatterns);
        foreach ($this->composerAutoloaderProjectPaths as $composerAutoloaderProjectPath) {
            $locator = $this->composerJsonAndInstalledJsonSourceLocatorMaker->create($composerAutoloaderProjectPath);
            if ($locator === null) {
                continue;
            }
            $locators[] = $locator;
        }
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\ClassWhitelistSourceLocator($this->autoloadSourceLocator, $this->staticReflectionClassNamePatterns);
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        $locators[] = new \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\PhpVersionBlacklistSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\EvaledCodeSourceLocator($astLocator, $this->reflectionSourceStubber), $this->phpstormStubsSourceStubber);
        return new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
