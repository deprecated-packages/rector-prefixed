<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\PhpDoc;

use RectorPrefix20201227\PHPStan\DependencyInjection\Container;
use RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class StubSourceLocatorFactory
{
    /** @var \PhpParser\Parser */
    private $parser;
    /** @var PhpStormStubsSourceStubber */
    private $phpStormStubsSourceStubber;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository */
    private $optimizedSingleFileSourceLocatorRepository;
    /** @var \PHPStan\DependencyInjection\Container */
    private $container;
    /** @var string[] */
    private $stubFiles;
    /**
     * @param string[] $stubFiles
     */
    public function __construct(\PhpParser\Parser $parser, \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \RectorPrefix20201227\PHPStan\DependencyInjection\Container $container, array $stubFiles)
    {
        $this->parser = $parser;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->container = $container;
        $this->stubFiles = $stubFiles;
    }
    public function create() : \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        $astLocator = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('stubFunctionReflector');
        });
        foreach ($this->stubFiles as $stubFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($stubFile);
        }
        $locators[] = new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpStormStubsSourceStubber);
        return new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \RectorPrefix20201227\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
