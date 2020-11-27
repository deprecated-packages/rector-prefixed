<?php

declare (strict_types=1);
namespace Rector\SimplePhpDocParser\Tests\SimplePhpDocParser;

use Rector\Core\HttpKernel\RectorKernel;
use Rector\SimplePhpDocParser\SimplePhpDocParser;
use Rector\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;
final class SimplePhpDocParserTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var SimplePhpDocParser
     */
    private $simplePhpDocParser;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->simplePhpDocParser = self::$container->get(\Rector\SimplePhpDocParser\SimplePhpDocParser::class);
    }
    public function testVar() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/var_int.txt');
        $phpDocNode = $this->simplePhpDocParser->parseDocBlock($smartFileInfo->getContents());
        $this->assertInstanceOf(\Rector\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode::class, $phpDocNode);
        $varTagValues = $phpDocNode->getVarTagValues();
        $this->assertCount(1, $varTagValues);
    }
    public function testParam() : void
    {
        $smartFileInfo = new \Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/param_string_name.txt');
        $phpDocNode = $this->simplePhpDocParser->parseDocBlock($smartFileInfo->getContents());
        $this->assertInstanceOf(\Rector\SimplePhpDocParser\ValueObject\Ast\PhpDoc\SimplePhpDocNode::class, $phpDocNode);
        // DX friendly
        $paramType = $phpDocNode->getParamType('name');
        $withDollarParamType = $phpDocNode->getParamType('$name');
        $this->assertSame($paramType, $withDollarParamType);
    }
}
