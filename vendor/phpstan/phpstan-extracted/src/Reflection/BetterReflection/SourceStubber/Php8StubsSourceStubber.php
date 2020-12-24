<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Reflection\BetterReflection\SourceStubber;

use _PhpScopere8e811afab72\PHPStan\File\FileReader;
use _PhpScopere8e811afab72\PHPStan\Php8StubsMap;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
class Php8StubsSourceStubber implements \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const DIRECTORY = __DIR__ . '/../../../../vendor/phpstan/php-8-stubs';
    public function hasClass(string $className) : bool
    {
        $className = \strtolower($className);
        return \array_key_exists($className, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES);
    }
    public function generateClassStub(string $className) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES)) {
            return null;
        }
        $relativeFilePath = \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\_PhpScopere8e811afab72\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateFunctionStub(string $functionName) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowerFunctionName, \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return null;
        }
        $relativeFilePath = \_PhpScopere8e811afab72\PHPStan\Php8StubsMap::FUNCTIONS[$lowerFunctionName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\_PhpScopere8e811afab72\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateConstantStub(string $constantName) : ?\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
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
