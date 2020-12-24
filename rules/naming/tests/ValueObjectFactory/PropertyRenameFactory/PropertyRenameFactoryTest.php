<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Naming\Tests\ValueObjectFactory\PropertyRenameFactory;

use Iterator;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScopere8e811afab72\Rector\FileSystemRector\Parser\FileInfoParser;
use _PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver;
use _PhpScopere8e811afab72\Rector\Naming\ValueObject\PropertyRename;
use _PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
use _PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo;
final class PropertyRenameFactoryTest extends \_PhpScopere8e811afab72\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
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
        $this->bootKernel(\_PhpScopere8e811afab72\Rector\Core\HttpKernel\RectorKernel::class);
        $this->propertyRenameFactory = $this->getService(\_PhpScopere8e811afab72\Rector\Naming\ValueObjectFactory\PropertyRenameFactory::class);
        $this->matchPropertyTypeExpectedNameResolver = $this->getService(\_PhpScopere8e811afab72\Rector\Naming\ExpectedNameResolver\MatchPropertyTypeExpectedNameResolver::class);
        $this->fileInfoParser = $this->getService(\_PhpScopere8e811afab72\Rector\FileSystemRector\Parser\FileInfoParser::class);
        $this->betterNodeFinder = $this->getService(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\BetterNodeFinder::class);
    }
    /**
     * @dataProvider provideData()
     */
    public function test(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfoWithProperty, string $expectedName, string $currentName) : void
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
        (yield [new \_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo(__DIR__ . '/Fixture/SomeClass.php.inc'), 'eliteManager', 'eventManager']);
    }
    private function getPropertyFromFileInfo(\_PhpScopere8e811afab72\Symplify\SmartFileSystem\SmartFileInfo $fileInfo) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property
    {
        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($fileInfo);
        /** @var Property|null $property */
        $property = $this->betterNodeFinder->findFirstInstanceOf($nodes, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class);
        if ($property === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $property;
    }
}
