<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Nette\Tests\Rector\ClassMethod\TranslateClassMethodToVariadicsRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Nette\Rector\ClassMethod\TranslateClassMethodToVariadicsRector;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class TranslateClassMethodToVariadicsRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $localFilePath = __DIR__ . '/../../../../../../vendor/nette/utils/src/Utils/ITranslator.php';
        if (\file_exists($localFilePath)) {
            $this->smartFileSystem->remove($localFilePath);
        }
        require_once __DIR__ . '/../../../../../../stubs/Nette/Localization/ITranslation.php';
        // to make test work with fixture
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScopere8e811afab72\Rector\Nette\Rector\ClassMethod\TranslateClassMethodToVariadicsRector::class;
    }
}
