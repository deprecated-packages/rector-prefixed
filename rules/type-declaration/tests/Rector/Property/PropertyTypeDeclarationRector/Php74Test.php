<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Tests\Rector\Property\PropertyTypeDeclarationRector;

use Iterator;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @requires PHP 7.4
 */
final class Php74Test extends \_PhpScoperb75b35f52b74\Rector\Testing\PHPUnit\AbstractRectorTestCase
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
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePhp74');
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES;
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\Rector\Property\PropertyTypeDeclarationRector::class;
    }
}
