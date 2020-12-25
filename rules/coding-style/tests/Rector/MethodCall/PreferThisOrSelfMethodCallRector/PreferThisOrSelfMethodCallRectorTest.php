<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector;

use Iterator;
use _PhpScoper8b9c402c5f32\PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase;
use Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class PreferThisOrSelfMethodCallRectorTest extends \Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::class => [\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase::class => 'self', \Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass::class => 'this', \_PhpScoper8b9c402c5f32\PHPUnit\Framework\TestCase::class => 'self']]];
    }
}
