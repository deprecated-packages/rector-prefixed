<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use _PhpScoperb75b35f52b74\Nette\Utils\Html;
use _PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use _PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\_PhpScoperb75b35f52b74\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoperb75b35f52b74\Nette\Utils\Html::class, 'add', \_PhpScoperb75b35f52b74\Nette\Utils\Html::class, 'addHtml'), new \_PhpScoperb75b35f52b74\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoperb75b35f52b74\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', '_PhpScoperb75b35f52b74\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
