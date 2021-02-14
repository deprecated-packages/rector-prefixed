<?php

declare (strict_types=1);
namespace RectorPrefix20210214\Symplify\AutowireArrayParameter\Tests\DocBlock;

use Iterator;
use RectorPrefix20210214\PHPUnit\Framework\TestCase;
use RectorPrefix20210214\Symplify\AutowireArrayParameter\DocBlock\ParamTypeDocBlockResolver;
final class ParamTypeDocBlockResolverTest extends \RectorPrefix20210214\PHPUnit\Framework\TestCase
{
    /**
     * @var ParamTypeDocBlockResolver
     */
    private $paramTypeDocBlockResolver;
    protected function setUp() : void
    {
        $this->paramTypeDocBlockResolver = new \RectorPrefix20210214\Symplify\AutowireArrayParameter\DocBlock\ParamTypeDocBlockResolver();
    }
    /**
     * @dataProvider provideData()
     */
    public function test(string $docBlock, string $parameterName, ?string $expectedType) : void
    {
        $resolvedType = $this->paramTypeDocBlockResolver->resolve($docBlock, $parameterName);
        $this->assertSame($expectedType, $resolvedType);
    }
    public function provideData() : \Iterator
    {
        (yield ['/** @param Type[] $name */', 'name', 'Type']);
        (yield ['/** @param Type[] $name */', '___not', null]);
        (yield ['/** @param array<Type> $name */', 'name', 'Type']);
        (yield ['/** @param iterable<Type> $name */', 'name', 'Type']);
    }
}
