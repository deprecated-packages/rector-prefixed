<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\PhpDoc;

use _PhpScopere8e811afab72\PHPStan\DependencyInjection\Container;
use _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\FunctionReflector;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
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
    public function __construct(\_PhpScopere8e811afab72\PhpParser\Parser $parser, \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\PhpStormStubsSourceStubber $phpStormStubsSourceStubber, \_PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository, \_PhpScopere8e811afab72\PHPStan\DependencyInjection\Container $container, array $stubFiles)
    {
        $this->parser = $parser;
        $this->phpStormStubsSourceStubber = $phpStormStubsSourceStubber;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
        $this->container = $container;
        $this->stubFiles = $stubFiles;
    }
    public function create() : \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
    {
        $locators = [];
        $astLocator = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Locator($this->parser, function () : FunctionReflector {
            return $this->container->getService('stubFunctionReflector');
        });
        foreach ($this->stubFiles as $stubFile) {
            $locators[] = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($stubFile);
        }
        $locators[] = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator($astLocator, $this->phpStormStubsSourceStubber);
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator(new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator($locators));
    }
}
