<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\ValueObjectFactory;

use Iterator;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory;
use Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Symfony\SymfonyRouteTagValueNodeFactory;
use Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory;
use Rector\Core\HttpKernel\RectorKernel;
use RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class TagValueNodeConfigurationFactoryTest extends \RectorPrefix20210308\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var TagValueNodeConfigurationFactory
     */
    private $tagValueNodeConfigurationFactory;
    /**
     * @var SymfonyRouteTagValueNodeFactory
     */
    private $symfonyRouteTagValueNodeFactory;
    /**
     * @var ColumnTagValueNodeFactory
     */
    private $columnTagValueNodeFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->tagValueNodeConfigurationFactory = $this->getService(\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory::class);
        $this->symfonyRouteTagValueNodeFactory = $this->getService(\Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Symfony\SymfonyRouteTagValueNodeFactory::class);
        $this->columnTagValueNodeFactory = $this->getService(\Rector\BetterPhpDocParser\ValueObjectFactory\PhpDocNode\Doctrine\ColumnTagValueNodeFactory::class);
    }
    public function test() : void
    {
        $symfonyRouteTagValueNode = $this->symfonyRouteTagValueNodeFactory->create();
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent('...', $symfonyRouteTagValueNode);
        $this->assertSame('=', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @dataProvider provideData()
     */
    public function testArrayColonIsNotChangedToEqual(string $originalContent) : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent($originalContent, $this->columnTagValueNodeFactory->create());
        $this->assertSame(':', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @return Iterator<string[]>
     */
    public function provideData() : \Iterator
    {
        (yield ['(type="integer", nullable=true, options={"default":0})']);
    }
}
