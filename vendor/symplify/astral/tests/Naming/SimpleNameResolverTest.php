<?php

declare(strict_types=1);

namespace Symplify\Astral\Tests\Naming;

use Iterator;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use Symplify\Astral\HttpKernel\AstralKernel;
use Symplify\Astral\Naming\SimpleNameResolver;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;

final class SimpleNameResolverTest extends AbstractKernelTestCase
{
    /**
     * @var SimpleNameResolver
     */
    private $simpleNameResolver;

    protected function setUp(): void
    {
        $this->bootKernel(AstralKernel::class);
        $this->simpleNameResolver = $this->getService(SimpleNameResolver::class);
    }

    /**
     * @dataProvider provideData()
     */
    public function test(Node $node, string $expectedName): void
    {
        $resolvedName = $this->simpleNameResolver->getName($node);
        $this->assertSame($expectedName, $resolvedName);
    }

    /**
     * @return Iterator<string[]|Identifier[]>
     */
    public function provideData(): Iterator
    {
        $identifier = new Identifier('first name');
        yield [$identifier, 'first name'];
    }
}
