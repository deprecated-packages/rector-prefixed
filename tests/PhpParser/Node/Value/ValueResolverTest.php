<?php

declare (strict_types=1);
namespace Rector\Core\Tests\PhpParser\Node\Value;

use Iterator;
use PhpParser\BuilderFactory;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Plus;
use PhpParser\Node\Name\FullyQualified;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Node\Value\ValueResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class ValueResolverTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->valueResolver = self::$container->get(\Rector\Core\PhpParser\Node\Value\ValueResolver::class);
    }
    /**
     * @param mixed $expected
     * @dataProvider dataProvider
     */
    public function test($expected, \PhpParser\Node\Expr $expr) : void
    {
        $this->assertSame($expected, $this->valueResolver->getValue($expr));
    }
    public function dataProvider() : \Iterator
    {
        $builderFactory = new \PhpParser\BuilderFactory();
        $classConstFetchNode = $builderFactory->classConstFetch('SomeClass', 'SOME_CONSTANT');
        $classConstFetchNode->class->setAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::RESOLVED_NAME, new \PhpParser\Node\Name\FullyQualified('SomeClassResolveName'));
        (yield ['SomeClassResolveName::SOME_CONSTANT', $classConstFetchNode]);
        (yield [\true, $builderFactory->val(\true)]);
        (yield [1, $builderFactory->val(1)]);
        (yield [1.0, $builderFactory->val(1.0)]);
        (yield [null, $builderFactory->var('foo')]);
        (yield [2, new \PhpParser\Node\Expr\BinaryOp\Plus($builderFactory->val(1), $builderFactory->val(1))]);
        (yield [null, new \PhpParser\Node\Expr\BinaryOp\Plus($builderFactory->val(1), $builderFactory->var('foo'))]);
    }
}
