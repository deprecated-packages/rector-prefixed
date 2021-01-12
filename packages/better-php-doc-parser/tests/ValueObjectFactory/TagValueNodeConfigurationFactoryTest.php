<?php

declare (strict_types=1);
namespace Rector\BetterPhpDocParser\Tests\ValueObjectFactory;

use Iterator;
use RectorPrefix20210112\PHPUnit\Framework\TestCase;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory;
final class TagValueNodeConfigurationFactoryTest extends \RectorPrefix20210112\PHPUnit\Framework\TestCase
{
    /**
     * @var TagValueNodeConfigurationFactory
     */
    private $tagValueNodeConfigurationFactory;
    protected function setUp() : void
    {
        $this->tagValueNodeConfigurationFactory = new \Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory();
    }
    public function test() : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent('...', new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode([]));
        $this->assertSame('=', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @dataProvider provideData()
     */
    public function testArrayColonIsNotChangedToEqual(string $originalContent) : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent($originalContent, new \Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode([]));
        $this->assertSame(':', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    public function provideData() : \Iterator
    {
        (yield ['(type="integer", nullable=true, options={"default":0})']);
    }
}
