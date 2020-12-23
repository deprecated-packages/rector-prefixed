<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\Tests\ValueObjectFactory;

use Iterator;
use _PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory;
final class TagValueNodeConfigurationFactoryTest extends \_PhpScoper0a2ac50786fa\PHPUnit\Framework\TestCase
{
    /**
     * @var TagValueNodeConfigurationFactory
     */
    private $tagValueNodeConfigurationFactory;
    protected function setUp() : void
    {
        $this->tagValueNodeConfigurationFactory = new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory();
    }
    public function test() : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent('...', new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode([]));
        $this->assertSame('=', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @dataProvider provideData()
     */
    public function testArrayColonIsNotChangedToEqual(string $originalContent) : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent($originalContent, new \_PhpScoper0a2ac50786fa\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode([]));
        $this->assertSame(':', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    public function provideData() : \Iterator
    {
        (yield ['(type="integer", nullable=true, options={"default":0})']);
    }
}
