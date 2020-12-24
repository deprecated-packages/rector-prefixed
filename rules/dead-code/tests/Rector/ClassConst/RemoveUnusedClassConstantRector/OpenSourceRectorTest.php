<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DeadCode\Tests\Rector\ClassConst\RemoveUnusedClassConstantRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\Configuration\Option;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\ProjectType;
use _PhpScoperb75b35f52b74\Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class OpenSourceRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->setParameter(\_PhpScoperb75b35f52b74\Rector\Core\Configuration\Option::PROJECT_TYPE, \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\ProjectType::OPEN_SOURCE);
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureOpenSource');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\DeadCode\Rector\ClassConst\RemoveUnusedClassConstantRector::class;
    }
}
