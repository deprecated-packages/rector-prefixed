<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class OptimizedPsrAutoloaderLocator implements \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /**
     * @var \Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping
     */
    private $mapping;
    /**
     * @var \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository
     */
    private $optimizedSingleFileSourceLocatorRepository;
    public function __construct(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping $mapping, \PHPStan\Reflection\BetterReflection\SourceLocator\OptimizedSingleFileSourceLocatorRepository $optimizedSingleFileSourceLocatorRepository)
    {
        $this->mapping = $mapping;
        $this->optimizedSingleFileSourceLocatorRepository = $optimizedSingleFileSourceLocatorRepository;
    }
    public function locateIdentifier(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\Reflection
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
    public function locateIdentifiersByType(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
        // todo
    }
}
