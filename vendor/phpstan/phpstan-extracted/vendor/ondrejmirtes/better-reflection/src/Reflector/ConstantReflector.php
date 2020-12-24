<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector;

use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function assert;
class ConstantReflector implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector
{
    /** @var SourceLocator */
    private $sourceLocator;
    /** @var ClassReflector */
    private $classReflector;
    public function __construct(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator $sourceLocator, \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\ClassReflector $classReflector)
    {
        $this->sourceLocator = $sourceLocator;
        $this->classReflector = $classReflector;
    }
    /**
     * Create a ReflectionConstant for the specified $constantName.
     *
     * @return ReflectionConstant
     *
     * @throws IdentifierNotFound
     */
    public function reflect(string $constantName) : \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        $identifier = new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($constantName, new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        $constantInfo = $this->sourceLocator->locateIdentifier($this->classReflector, $identifier);
        \assert($constantInfo instanceof \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant || $constantInfo === null);
        if ($constantInfo === null) {
            throw \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Exception\IdentifierNotFound::fromIdentifier($identifier);
        }
        return $constantInfo;
    }
    /**
     * Get all the constants available in the scope specified by the SourceLocator.
     *
     * @return array<int, ReflectionConstant>
     */
    public function getAllConstants() : array
    {
        /** @var array<int,ReflectionConstant> $allConstants */
        $allConstants = $this->sourceLocator->locateIdentifiersByType($this, new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType(\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType::IDENTIFIER_CONSTANT));
        return $allConstants;
    }
}
