<?php

declare (strict_types=1);
namespace PHPStan\PhpDoc;

use PHPStan\DependencyInjection\Container;
use PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use _PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class StubSourceLocatorFactory
{
    /**
     * @var \PhpParser\Parser
     */
    private $parser;
    /**
     * @var \Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber
     */
    private $phpStormStubsSourceStubber;
    /**
     * @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository
     */
    private $optimizedSingleFileSourceLocatorRepository;
    /**
     * @var \PHPStan\DependencyInjection\Container
     */
    private $container;
    /** @var string[] */
    private $stubFiles;
    /**
     * @param string[] $stubFiles
     */
    public function __construct(\PhpParser\Parser $parser, \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \PHPStan\DependencyInjection\Container $container, array $stubFiles)
    {
        $this->parser = $parser;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->container = $container;
        $this->stubFiles = $stubFiles;
    }
    public function create() : \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        $astLocator = new \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('stubFunctionReflector');
        });
        foreach ($this->stubFiles as $stubFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($stubFile);
        }
        $locators[] = new \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpStormStubsSourceStubber);
        return new \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_PhpScoper26e51eeacccf\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
