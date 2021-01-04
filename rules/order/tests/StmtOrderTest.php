<?php

declare (strict_types=1);
namespace Rector\Order\Tests;

use Iterator;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\PropertyProperty;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\Order\StmtOrder;
use RectorPrefix20210104\Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class StmtOrderTest extends \RectorPrefix20210104\Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var int[]
     */
    private const OLD_TO_NEW_KEYS = [0 => 0, 1 => 2, 2 => 1];
    /**
     * @var StmtOrder
     */
    private $stmtOrder;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->stmtOrder = $this->getService(\Rector\Order\StmtOrder::class);
        $this->nodeNameResolver = $this->getService(\Rector\NodeNameResolver\NodeNameResolver::class);
    }
    public function dataProvider() : \Iterator
    {
        (yield [['first', 'second', 'third'], ['third', 'first', 'second'], [0 => 1, 1 => 2, 2 => 0]]);
        (yield [['first', 'second', 'third'], ['third', 'second', 'first'], [0 => 2, 1 => 1, 2 => 0]]);
        (yield [['first', 'second', 'third'], ['first', 'second', 'third'], [0 => 0, 1 => 1, 2 => 2]]);
    }
    /**
     * @dataProvider dataProvider
     * @param array<int,string> $desiredStmtOrder
     * @param array<int,string> $currentStmtOrder
     * @param array<int,int> $expected
     */
    public function testCreateOldToNewKeys(array $desiredStmtOrder, array $currentStmtOrder, array $expected) : void
    {
        $actual = $this->stmtOrder->createOldToNewKeys($desiredStmtOrder, $currentStmtOrder);
        $this->assertSame($expected, $actual);
    }
    public function testReorderClassStmtsByOldToNewKeys() : void
    {
        $class = $this->getTestClassNode();
        $classLike = $this->stmtOrder->reorderClassStmtsByOldToNewKeys($class, self::OLD_TO_NEW_KEYS);
        $expectedClass = $this->getExpectedClassNode();
        $this->assertSame($this->nodeNameResolver->getName($expectedClass->stmts[0]), $this->nodeNameResolver->getName($classLike->stmts[0]));
        $this->assertSame($this->nodeNameResolver->getName($expectedClass->stmts[1]), $this->nodeNameResolver->getName($classLike->stmts[1]));
        $this->assertSame($this->nodeNameResolver->getName($expectedClass->stmts[2]), $this->nodeNameResolver->getName($classLike->stmts[2]));
    }
    private function getTestClassNode() : \PhpParser\Node\Stmt\Class_
    {
        $class = new \PhpParser\Node\Stmt\Class_('ClassUnderTest');
        $class->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('name')]);
        $class->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('service')]);
        $class->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('price')]);
        return $class;
    }
    private function getExpectedClassNode() : \PhpParser\Node\Stmt\Class_
    {
        $expectedClass = new \PhpParser\Node\Stmt\Class_('ExpectedClass');
        $expectedClass->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('name')]);
        $expectedClass->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('price')]);
        $expectedClass->stmts[] = new \PhpParser\Node\Stmt\Property(\PhpParser\Node\Stmt\Class_::MODIFIER_PRIVATE, [new \PhpParser\Node\Stmt\PropertyProperty('service')]);
        return $expectedClass;
    }
}
