<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Reflection\BetterReflection\SourceStubber;

use RectorPrefix20201227\PHPStan\File\FileReader;
use RectorPrefix20201227\PHPStan\Php8StubsMap;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
class Php8StubsSourceStubber implements \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const DIRECTORY = __DIR__ . '/../../../../vendor/phpstan/php-8-stubs';
    public function hasClass(string $className) : bool
    {
        $className = \strtolower($className);
        return \array_key_exists($className, \RectorPrefix20201227\PHPStan\Php8StubsMap::CLASSES);
    }
    public function generateClassStub(string $className) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \RectorPrefix20201227\PHPStan\Php8StubsMap::CLASSES)) {
            return null;
        }
        $relativeFilePath = \RectorPrefix20201227\PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\RectorPrefix20201227\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateFunctionStub(string $functionName) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowerFunctionName, \RectorPrefix20201227\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return null;
        }
        $relativeFilePath = \RectorPrefix20201227\PHPStan\Php8StubsMap::FUNCTIONS[$lowerFunctionName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\RectorPrefix20201227\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateConstantStub(string $constantName) : ?\RectorPrefix20201227\_HumbugBox221ad6f1b81f__UniqueRector\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
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
