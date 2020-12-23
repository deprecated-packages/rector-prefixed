<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector;

use Iterator;
use _PhpScoper0a2ac50786fa\Nette\Utils\Html;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameStaticMethod;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameStaticMethodRectorTest extends \_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        return [\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::class => [\_PhpScoper0a2ac50786fa\Rector\Renaming\Rector\StaticCall\RenameStaticMethodRector::OLD_TO_NEW_METHODS_BY_CLASSES => [new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper0a2ac50786fa\Nette\Utils\Html::class, 'add', \_PhpScoper0a2ac50786fa\Nette\Utils\Html::class, 'addHtml'), new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\RenameStaticMethod(\_PhpScoper0a2ac50786fa\Rector\Renaming\Tests\Rector\StaticCall\RenameStaticMethodRector\Source\FormMacros::class, 'renderFormBegin', '_PhpScoper0a2ac50786fa\\Nette\\Bridges\\FormsLatte\\Runtime', 'renderFormBegin')]]];
    }
}
