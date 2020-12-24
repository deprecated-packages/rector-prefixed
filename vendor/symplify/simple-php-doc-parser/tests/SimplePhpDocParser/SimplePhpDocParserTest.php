<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Tests\SimplePhpDocParser;

use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\SimplePhpDocParser;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Tests\HttpKernel\SimplePhpDocParserKernel;
use _PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class SimplePhpDocParserTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SimplePhpDocParser
     */
    private $simplePhpDocParser;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\Tests\HttpKernel\SimplePhpDocParserKernel::class);
        $this->simplePhpDocParser = $this->getService(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\SimplePhpDocParser::class);
    }
    public function testVar() : void
    {
        $smartFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/var_int.txt');
        $phpDocNode = $this->simplePhpDocParser->parseDocBlock($smartFileInfo->getContents());
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode::class, $phpDocNode);
        $varTagValues = $phpDocNode->getVarTagValues();
        $this->assertCount(1, $varTagValues);
    }
    public function testParam() : void
    {
        $smartFileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/param_string_name.txt');
        $phpDocNode = $this->simplePhpDocParser->parseDocBlock($smartFileInfo->getContents());
        $this->assertInstanceOf(\_PhpScoperb75b35f52b74\Symplify\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode::class, $phpDocNode);
        // DX friendly
        $paramType = $phpDocNode->getParamType('name');
        $withDollarParamType = $phpDocNode->getParamType('$name');
        $this->assertSame($paramType, $withDollarParamType);
    }
}
