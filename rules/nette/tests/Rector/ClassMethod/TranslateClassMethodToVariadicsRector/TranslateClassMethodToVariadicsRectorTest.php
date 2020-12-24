<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Nette\Tests\Rector\ClassMethod\TranslateClassMethodToVariadicsRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Nette\Rector\ClassMethod\TranslateClassMethodToVariadicsRector;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class TranslateClassMethodToVariadicsRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return \_PhpScoper0a6b37af0871\Rector\Nette\Rector\ClassMethod\TranslateClassMethodToVariadicsRector::class;
    }
}
