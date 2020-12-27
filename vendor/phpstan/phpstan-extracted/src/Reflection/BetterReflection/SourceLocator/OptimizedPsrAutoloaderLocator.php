<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator;

use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\Identifier;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\IdentifierType;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflection\Reflection;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class OptimizedPsrAutoloaderLocator implements \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var PsrAutoloaderMapping */
    private $mapping;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository */
    private $optimizedSingleFileSourceLocatorRepository;
    public function __construct(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping $mapping, \RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository)
    {
        $this->mapping = $mapping;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
    }
    public function locateIdentifier(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflection\Reflection
    {
        foreach ($this->mapping->resolvePossibleFilePaths($identifier) as $file) {
            if (!\file_exists($file)) {
                continue;
            }
            $reflection = $this->optimizedSingleFileSourceLocatorRepository->getOrCreate($file)->locateIdentifier($reflector, $identifier);
            if ($reflection === null) {
                continue;
            }
            return $reflection;
        }
        return null;
    }
    /**
     * @return Reflection[]
     */
    public function locateIdentifiersByType(\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Reflector\Reflector $reflector, \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
    }
}
