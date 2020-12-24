<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector;

use Iterator;
use _PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PreferThisOrSelfMethodCallRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::class => [\_PhpScoper0a6b37af0871\Rector\CodingStyle\Rector\MethodCall\PreferThisOrSelfMethodCallRector::TYPE_TO_PREFERENCE => [\_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\AbstractTestCase::class => 'self', \_PhpScoper0a6b37af0871\Rector\CodingStyle\Tests\Rector\MethodCall\PreferThisOrSelfMethodCallRector\Source\BeLocalClass::class => 'this', \_PhpScoper0a6b37af0871\PHPUnit\Framework\TestCase::class => 'self']]];
    }
}
