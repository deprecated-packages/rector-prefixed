<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNonPhpTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRenameNonPhp', \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern());
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            // Laravel
            'Session' => '_PhpScoper0a6b37af0871\\Illuminate\\Support\\Facades\\Session',
            'Form' => '_PhpScoper0a6b37af0871\\Collective\\Html\\FormFacade',
            'Html' => '_PhpScoper0a6b37af0871\\Collective\\Html\\HtmlFacade',
        ]]];
    }
}
