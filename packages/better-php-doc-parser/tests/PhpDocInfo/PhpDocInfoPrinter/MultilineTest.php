<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Property;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\AnotherPropertyClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Class_\SomeEntityClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\DoctrinePropertyClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\ManyToPropertyClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\RoutePropertyClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\SinglePropertyClass;
use Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\TableClass;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo;
final class MultilineTest extends \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\AbstractPhpDocInfoPrinterTest
{
    /**
     * @dataProvider provideData()
     * @dataProvider provideDataForProperty()
     * @dataProvider provideDataClass()
     */
    public function test(string $docFilePath, \PhpParser\Node $node) : void
    {
        $docComment = $this->smartFileSystem->readFile($docFilePath);
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($docComment, $node);
        $fileInfo = new \RectorPrefix20210117\Symplify\SmartFileSystem\SmartFileInfo($docFilePath);
        $relativeFilePathFromCwd = $fileInfo->getRelativeFilePathFromCwd();
        $printedPhpDocInfo = $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo);
        $this->assertSame($docComment, $printedPhpDocInfo, $relativeFilePathFromCwd);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/Multiline/multiline1.txt', new \PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline2.txt', new \PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline3.txt', new \PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline4.txt', new \PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline5.txt', new \PhpParser\Node\Stmt\Nop()]);
    }
    public function provideDataClass() : \Iterator
    {
        (yield [__DIR__ . '/Source/Class_/some_entity_class.txt', new \PhpParser\Node\Stmt\Class_(\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Class_\SomeEntityClass::class)]);
        (yield [__DIR__ . '/Source/Multiline/table.txt', new \PhpParser\Node\Stmt\Class_(\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\TableClass::class)]);
    }
    public function provideDataForProperty() : \Iterator
    {
        $property = $this->createPublicPropertyUnderClass('manyTo', \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\ManyToPropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/many_to.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('anotherProperty', \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\AnotherPropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/assert_serialize.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('anotherSerializeSingleLine', \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\SinglePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/assert_serialize_single_line.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('someProperty', \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\DoctrinePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/multiline6.txt', $property]);
        $property = $this->createMethodUnderClass('someMethod', \Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\RoutePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/route_property.txt', $property]);
    }
    private function createPublicPropertyUnderClass(string $name, string $class) : \PhpParser\Node\Stmt\Property
    {
        $builderFactory = new \PhpParser\BuilderFactory();
        $propertyBuilder = $builderFactory->property($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $property->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $class);
        return $property;
    }
    private function createMethodUnderClass(string $name, string $class) : \PhpParser\Node\Stmt\ClassMethod
    {
        $builderFactory = new \PhpParser\BuilderFactory();
        $methodBuilder = $builderFactory->method($name);
        $methodBuilder->makePublic();
        $classMethod = $methodBuilder->getNode();
        $classMethod->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $class);
        return $classMethod;
    }
}
