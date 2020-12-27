<?php

declare (strict_types=1);
namespace PHPStan\Reflection\BetterReflection\SourceStubber;

use PHPStan\File\FileReader;
use PHPStan\Php8StubsMap;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
class Php8StubsSourceStubber implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const DIRECTORY = __DIR__ . '/../../../../vendor/phpstan/php-8-stubs';
    public function hasClass(string $className) : bool
    {
        $className = \strtolower($className);
        return \array_key_exists($className, \PHPStan\Php8StubsMap::CLASSES);
    }
    public function generateClassStub(string $className) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \PHPStan\Php8StubsMap::CLASSES)) {
            return null;
        }
        $relativeFilePath = \PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateFunctionStub(string $functionName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowerFunctionName, \PHPStan\Php8StubsMap::FUNCTIONS)) {
            return null;
        }
        $relativeFilePath = \PHPStan\Php8StubsMap::FUNCTIONS[$lowerFunctionName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateConstantStub(string $constantName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        return null;
    }
    private function getExtensionFromFilePath(string $relativeFilePath) : string
    {
        $pathParts = \explode('/', $relativeFilePath);
        if ($pathParts[1] === 'Zend') {
            return 'Core';
        }
        return $pathParts[2];
    }
}
