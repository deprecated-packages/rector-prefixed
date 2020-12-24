<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Tests\Rector\FunctionLike\ParamTypeDeclarationRector;

use Iterator;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyTypeParamTypeDeclarationRectorTest extends \_PhpScoper0a6b37af0871\Rector\Testing\PHPUnit\AbstractRectorTestCase
{
    /**
     * @requires PHP 7.4
     * @dataProvider provideData()
     */
    public function test(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : void
    {
        $this->doTestFileInfo($fileInfo);
    }
    public function provideData() : \Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/FixturePropertyType');
    }
    protected function getRectorClass() : string
    {
        return \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector::class;
    }
    protected function getPhpVersion() : int
    {
        return \_PhpScoper0a6b37af0871\Rector\Core\ValueObject\PhpVersionFeature::TYPED_PROPERTIES;
    }
}
