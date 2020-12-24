<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\BuilderFactory;
use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\AnotherPropertyClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Class_\SomeEntityClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\DoctrinePropertyClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\ManyToPropertyClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\RoutePropertyClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\SinglePropertyClass;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\TableClass;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class MultilineTest extends \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\AbstractPhpDocInfoPrinterTest
{
    /**
     * @dataProvider provideData()
     * @dataProvider provideDataForProperty()
     * @dataProvider provideDataClass()
     */
    public function test(string $docFilePath, \_PhpScoperb75b35f52b74\PhpParser\Node $node) : void
    {
        $docComment = $this->smartFileSystem->readFile($docFilePath);
        $phpDocInfo = $this->createPhpDocInfoFromDocCommentAndNode($docComment, $node);
        $fileInfo = new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo($docFilePath);
        $relativeFilePathFromCwd = $fileInfo->getRelativeFilePathFromCwd();
        $this->assertSame($docComment, $this->phpDocInfoPrinter->printFormatPreserving($phpDocInfo), $relativeFilePathFromCwd);
    }
    public function provideData() : \Iterator
    {
        (yield [__DIR__ . '/Source/Multiline/multiline1.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline2.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline3.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline4.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()]);
        (yield [__DIR__ . '/Source/Multiline/multiline5.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Nop()]);
    }
    public function provideDataClass() : \Iterator
    {
        (yield [__DIR__ . '/Source/Class_/some_entity_class.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\Class_\SomeEntityClass::class)]);
        (yield [__DIR__ . '/Source/Multiline/table.txt', new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\TableClass::class)]);
    }
    public function provideDataForProperty() : \Iterator
    {
        $property = $this->createPublicPropertyUnderClass('manyTo', \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\ManyToPropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/many_to.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('anotherProperty', \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\AnotherPropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/assert_serialize.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('anotherSerializeSingleLine', \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\SinglePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/assert_serialize_single_line.txt', $property]);
        $property = $this->createPublicPropertyUnderClass('someProperty', \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\DoctrinePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/multiline6.txt', $property]);
        $property = $this->createMethodUnderClass('someMethod', \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\PhpDocInfo\PhpDocInfoPrinter\Source\RoutePropertyClass::class);
        (yield [__DIR__ . '/Source/Multiline/route_property.txt', $property]);
    }
    private function createPublicPropertyUnderClass(string $name, string $class) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $builderFactory = new \_PhpScoperb75b35f52b74\PhpParser\BuilderFactory();
        $propertyBuilder = $builderFactory->property($name);
        $propertyBuilder->makePublic();
        $property = $propertyBuilder->getNode();
        $property->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $class);
        return $property;
    }
    private function createMethodUnderClass(string $name, string $class) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod
    {
        $builderFactory = new \_PhpScoperb75b35f52b74\PhpParser\BuilderFactory();
        $methodBuilder = $builderFactory->method($name);
        $methodBuilder->makePublic();
        $classMethod = $methodBuilder->getNode();
        $classMethod->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME, $class);
        return $classMethod;
    }
}
