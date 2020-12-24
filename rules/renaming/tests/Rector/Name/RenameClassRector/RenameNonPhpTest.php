<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\StaticNonPhpFileSuffixes;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameNonPhpTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfoWithoutAutoload($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixtureRenameNonPhp', \_PhpScopere8e811afab72\Rector\Core\ValueObject\StaticNonPhpFileSuffixes::getSuffixRegexPattern());
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            // Laravel
            'Session' => '_PhpScopere8e811afab72\\Illuminate\\Support\\Facades\\Session',
            'Form' => '_PhpScopere8e811afab72\\Collective\\Html\\FormFacade',
            'Html' => '_PhpScopere8e811afab72\\Collective\\Html\\HtmlFacade',
        ]]];
    }
}
