<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector;

use Iterator;
use _PhpScoper0a6b37af0871\Manual\Twig\TwigFilter;
use _PhpScoper0a6b37af0871\Manual_Twig_Filter;
use _PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass;
use _PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class RenameClassRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
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
        $fixtureFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/FixtureDuplication/skip_duplicated_class.php.inc');
        $this->doTestFileInfo($fixtureFileInfo);
    }
    /**
     * @return array<string, mixed[]>
     */
    protected function getRectorsWithConfiguration() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::class => [\_PhpScoper0a6b37af0871\Rector\Renaming\Rector\Name\RenameClassRector::OLD_TO_NEW_CLASSES => [
            'FqnizeNamespaced' => '_PhpScoper0a6b37af0871\\Abc\\FqnizeNamespaced',
            \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClass::class => \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClass::class,
            \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\OldClassWithTypo::class => \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\NewClassWithoutTypo::class,
            'DateTime' => 'DateTimeInterface',
            'Countable' => 'stdClass',
            \_PhpScoper0a6b37af0871\Manual_Twig_Filter::class => \_PhpScoper0a6b37af0871\Manual\Twig\TwigFilter::class,
            'Twig_AbstractManualExtension' => \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Source\AbstractManualExtension::class,
            'Twig_Extension_Sandbox' => '_PhpScoper0a6b37af0871\\Twig\\Extension\\SandboxExtension',
            // Renaming class itself and its namespace
            '_PhpScoper0a6b37af0871\\MyNamespace\\MyClass' => '_PhpScoper0a6b37af0871\\MyNewNamespace\\MyNewClass',
            '_PhpScoper0a6b37af0871\\MyNamespace\\MyTrait' => '_PhpScoper0a6b37af0871\\MyNewNamespace\\MyNewTrait',
            '_PhpScoper0a6b37af0871\\MyNamespace\\MyInterface' => '_PhpScoper0a6b37af0871\\MyNewNamespace\\MyNewInterface',
            'MyOldClass' => '_PhpScoper0a6b37af0871\\MyNamespace\\MyNewClass',
            'AnotherMyOldClass' => 'AnotherMyNewClass',
            '_PhpScoper0a6b37af0871\\MyNamespace\\AnotherMyClass' => 'MyNewClassWithoutNamespace',
            // test duplicated class - @see https://github.com/rectorphp/rector/issues/1438
            '_PhpScoper0a6b37af0871\\Rector\\Renaming\\Tests\\Rector\\Name\\RenameClassRector\\Fixture\\SingularClass' => \_PhpScoper0a6b37af0871\Rector\Renaming\Tests\Rector\Name\RenameClassRector\Fixture\DuplicatedClass::class,
        ]]];
    }
}
