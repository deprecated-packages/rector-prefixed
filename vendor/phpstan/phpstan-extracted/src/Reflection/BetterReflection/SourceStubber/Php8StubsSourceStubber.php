<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\PHPStan\Reflection\BetterReflection\SourceStubber;

use _PhpScoperb75b35f52b74\PHPStan\File\FileReader;
use _PhpScoperb75b35f52b74\PHPStan\Php8StubsMap;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber;
use _PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData;
class Php8StubsSourceStubber implements \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const DIRECTORY = __DIR__ . '/../../../../vendor/phpstan/php-8-stubs';
    public function hasClass(string $className) : bool
    {
        $className = \strtolower($className);
        return \array_key_exists($className, \_PhpScoperb75b35f52b74\PHPStan\Php8StubsMap::CLASSES);
    }
    public function generateClassStub(string $className) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerClassName = \strtolower($className);
        if (!\array_key_exists($lowerClassName, \_PhpScoperb75b35f52b74\PHPStan\Php8StubsMap::CLASSES)) {
            return null;
        }
        $relativeFilePath = \_PhpScoperb75b35f52b74\PHPStan\Php8StubsMap::CLASSES[$lowerClassName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\_PhpScoperb75b35f52b74\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateFunctionStub(string $functionName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowerFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowerFunctionName, \_PhpScoperb75b35f52b74\PHPStan\Php8StubsMap::FUNCTIONS)) {
            return null;
        }
        $relativeFilePath = \_PhpScoperb75b35f52b74\PHPStan\Php8StubsMap::FUNCTIONS[$lowerFunctionName];
        $file = self::DIRECTORY . '/' . $relativeFilePath;
        return new \_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData(\_PhpScoperb75b35f52b74\PHPStan\File\FileReader::read($file), $this->getExtensionFromFilePath($relativeFilePath), $file);
    }
    public function generateConstantStub(string $constantName) : ?\_PhpScoperb75b35f52b74\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
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
