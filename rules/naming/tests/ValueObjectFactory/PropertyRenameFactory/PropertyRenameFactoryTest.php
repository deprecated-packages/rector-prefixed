<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Naming\Tests\ValueObjectFactory\PropertyRenameFactory;

use Iterator;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoperb75b35f52b74\Rector\FileSystemRector\Parser\FileInfoParser;
use _PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObject\PropertyRename;
use _PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyRenameFactoryTest extends \_PhpScoperb75b35f52b74\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var PropertyRenameFactory
     */
    private $propertyRenameFactory;
    /**
     * @var FileInfoParser
     */
    private $fileInfoParser;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var MatchPropertyTypeExpectedNameResolver
     */
    private $matchPropertyTypeExpectedNameResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\_PhpScoperb75b35f52b74\Rector\Core\HttpKernel\RectorKernel::class);
        $this->propertyRenameFactory = $this->getService(\_PhpScoperb75b35f52b74\Rector\Naming\ValueObjectFactory\PropertyRenameFactory::class);
        $this->matchPropertyTypeExpectedNameResolver = $this->getService(\_PhpScoperb75b35f52b74\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver::class);
        $this->fileInfoParser = $this->getService(\_PhpScoperb75b35f52b74\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterNodeFinder = $this->getService(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfoWithProperty, string $expectedName, string $currentName) : void
    {
        $property = $this->getPropertyFromFileInfo($fileInfoWithProperty);
        $actualPropertyRename = $this->propertyRenameFactory->create($property, $this->matchPropertyTypeExpectedNameResolver);
        $this->assertNotNull($actualPropertyRename);
        /** @var PropertyRename $actualPropertyRename */
        $this->assertSame($property, $actualPropertyRename->getProperty());
        $this->assertSame($expectedName, $actualPropertyRename->getExpectedName());
        $this->assertSame($currentName, $actualPropertyRename->getCurrentName());
    }
    public function provideData() : \Iterator
    {
        (yield [new \_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/SomeClass.php.inc'), 'eliteManager', 'eventManager']);
    }
    private function getPropertyFromFileInfo(\_PhpScoperb75b35f52b74\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property
    {
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfo);
        /** @var Property|null $property */
        $property = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property::class);
        if ($property === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $property;
    }
}
