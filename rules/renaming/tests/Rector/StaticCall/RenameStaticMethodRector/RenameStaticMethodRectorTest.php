<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use _PhpScopere8e811afab72\Nette\Utils\Html;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use _PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScopere8e811afab72\Nette\Utils\Html::class, 'add', \_PhpScopere8e811afab72\Nette\Utils\Html::class, 'addHtml'), new \_PhpScopere8e811afab72\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', '_PhpScopere8e811afab72\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
