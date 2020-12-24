<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\BetterPhpDocParser\Tests\ValueObjectFactory;

use Iterator;
use _PhpScopere8e811afab72\PHPUnit\Framework\TestCase;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory;
final class TagValueNodeConfigurationFactoryTest extends \_PhpScopere8e811afab72\PHPUnit\Framework\TestCase
{
    /**
     * @var TagValueNodeConfigurationFactory
     */
    private $tagValueNodeConfigurationFactory;
    protected function setUp() : void
    {
        $this->tagValueNodeConfigurationFactory = new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObjectFactory\TagValueNodeConfigurationFactory();
    }
    public function test() : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent('...', new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode([]));
        $this->assertSame('=', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    /**
     * @dataProvider provideData()
     */
    public function testArrayColonIsNotChangedToEqual(string $originalContent) : void
    {
        $tagValueNodeConfiguration = $this->tagValueNodeConfigurationFactory->createFromOriginalContent($originalContent, new \_PhpScopere8e811afab72\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Doctrine\Property_\ColumnTagValueNode([]));
        $this->assertSame(':', $tagValueNodeConfiguration->getArrayEqualSign());
    }
    public function provideData() : \Iterator
    {
        (yield ['(type="integer", nullable=true, options={"default":0})']);
    }
}
