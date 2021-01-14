<?php

declare (strict_types=1);
namespace RectorPrefix20210114\Symplify\Astral\Tests\NodeValue;

use Iterator;
use PhpParser\Node\Expr;
use PhpParser\Node\Scalar\String_;
use RectorPrefix20210114\PHPUnit\Framework\TestCase;
use RectorPrefix20210114\Symplify\Astral\NodeValue\NodeValueResolver;
use RectorPrefix20210114\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory;
use RectorPrefix20210114\Symplify\PackageBuilder\Php\TypeChecker;
final class NodeValueResolverTest extends \RectorPrefix20210114\PHPUnit\Framework\TestCase
{
    /**
     * @var NodeValueResolver
     */
    private $nodeValueResolver;
    protected function setUp() : void
    {
        $simpleNameResolver = \RectorPrefix20210114\Symplify\Astral\StaticFactory\SimpleNameResolverStaticFactory::create();
        $this->nodeValueResolver = new \RectorPrefix20210114\Symplify\Astral\NodeValue\NodeValueResolver($simpleNameResolver, new \RectorPrefix20210114\Symplify\PackageBuilder\Php\TypeChecker());
    }
    /**
     * @dataProvider provideData()
     * @param mixed $expectedValue
     */
    public function test(\PhpParser\Node\Expr $expr, $expectedValue) : void
    {
        $resolvedValue = $this->nodeValueResolver->resolve($expr, __FILE__);
        $this->assertSame($expectedValue, $resolvedValue);
    }
    public function provideData() : \Iterator
    {
        (yield [new \PhpParser\Node\Scalar\String_('value'), 'value']);
    }
}
