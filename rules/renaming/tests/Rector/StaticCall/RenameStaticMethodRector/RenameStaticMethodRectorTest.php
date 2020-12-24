<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Html;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use _PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \_PhpScoper2a4e7ab1ecbc\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Html::class, 'add', \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Html::class, 'addHtml'), new \_PhpScoper2a4e7ab1ecbc\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper2a4e7ab1ecbc\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', '_PhpScoper2a4e7ab1ecbc\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
