<?php

declare (strict_types=1);
namespace Rector\Transform\Tests\Rector\New_\NewToConstructorInjectionRector;

use Iterator;
use Rector\Core\ValueObject\PhpVersionFeature;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Rector\Transform\Rector\New_\NewToConstructorInjectionRector;
use Rector\Transform\Tests\Rector\New_\NewToConstructorInjectionRector\Source\DummyValidator;
use RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo;
final class Php80Test extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\RectorPrefix20210121\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp80');
    }
    protected function getPhpVersion() : int
    {
        return \Rector\Core\ValueObject\PhpVersionFeature::PROPERTY_PROMOTION;
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\Transform\Rector\New_\NewToConstructorInjectionRector::class => [\Rector\Transform\Rector\New_\NewToConstructorInjectionRector::TYPES_TO_CONSTRUCTOR_INJECTION => [\Rector\Transform\Tests\Rector\New_\NewToConstructorInjectionRector\Source\DummyValidator::class]]];
    }
}
