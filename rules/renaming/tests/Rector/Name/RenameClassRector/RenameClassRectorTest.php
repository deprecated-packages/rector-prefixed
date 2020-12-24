<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScopere8e811afab72\Manual\Twig\TwigFilter;
use _PhpScopere8e811afab72\Manual_Twig_Filter;
use _PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo;
use _PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassRectorTest extends \_PhpScopere8e811afab72\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
     * @see https://github.com/rectorphp/rector/issues/1438
     */
    public function testClassNameDuplication() : void
    {
        $fixtureFileInfo = new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureDuplication/skip_duplicated_class.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScopere8e811afab72\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            'FqnizeNamespaced' => '_PhpScopere8e811afab72\\Abc\\FqnizeNamespaced',
            \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo::class => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo::class,
            'DateTime' => 'DateTimeInterface',
            'Countable' => 'stdClass',
            \_PhpScopere8e811afab72\Manual_Twig_Filter::class => \_PhpScopere8e811afab72\Manual\Twig\TwigFilter::class,
            'Twig_AbstractManualExtension' => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension::class,
            'Twig_Extension_Sandbox' => '_PhpScopere8e811afab72\\Twig\\Extension\\SandboxExtension',
            // Renaming class itself and its namespace
            '_PhpScopere8e811afab72\\MyNamespace\\MyClass' => '_PhpScopere8e811afab72\\MyNewNamespace\\MyNewClass',
            '_PhpScopere8e811afab72\\MyNamespace\\MyTrait' => '_PhpScopere8e811afab72\\MyNewNamespace\\MyNewTrait',
            '_PhpScopere8e811afab72\\MyNamespace\\MyInterface' => '_PhpScopere8e811afab72\\MyNewNamespace\\MyNewInterface',
            'MyOldClass' => '_PhpScopere8e811afab72\\MyNamespace\\MyNewClass',
            'AnotherMyOldClass' => 'AnotherMyNewClass',
            '_PhpScopere8e811afab72\\MyNamespace\\AnotherMyClass' => 'MyNewClassWithoutNamespace',
            // test duplicated class - @see https://github.com/rectorphp/rector/issues/1438
            '_PhpScopere8e811afab72\\Rector\\Renaming\\Tests\\Rector\\Name\\RenameClassRector\\Fixture\\SingularClass' => \_PhpScopere8e811afab72\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass::class,
        ]]];
    }
}
