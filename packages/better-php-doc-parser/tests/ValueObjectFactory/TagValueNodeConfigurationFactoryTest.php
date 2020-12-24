<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\Tests\ValueObjectFactory;

use Iterator;
use _PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory;
final class TagValueNodeConfigurationFactoryTest extends \_PhpScoperb75b35f52b74\PHPUnit\Framework\TestCase
{
    /**
     * @var TagValueNodeConfigurationFactory
     */
    private $tagValueNodeConfigurationFactory;
    protected function setUp() : void
    {
        $this->tagValueNodeConfigurationFactory = new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory();
    }
    public function test() : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent('...', new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode([]));
        $this->assertSame('=', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @dataProvider provideData()
     */
    public function testArrayColonIsNotChangedToEqual(string $originalContent) : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent($originalContent, new \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode([]));
        $this->assertSame(':', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    public function provideData() : \Iterator
    {
        (yield ['(type="integer", nullable=true, options={"default":0})']);
    }
}
