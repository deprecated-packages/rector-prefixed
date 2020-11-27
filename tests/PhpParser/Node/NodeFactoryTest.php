<?php

declare (strict_types=1);
namespace Rector\Core\Tests\PhpParser\Node;

use Iterator;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Expr\ArrayItem;
use PhpParser\Node\Scalar\LNumber;
use PhpParser\Node\Scalar\String_;
use Rector\Core\HttpKernel\RectorKernel;
use Rector\Core\PhpParser\Node\NodeFactory;
use Symplify\PackageBuilder\Testing\AbstractKernelTestCase;
final class NodeFactoryTest extends \Symplify\PackageBuilder\Testing\AbstractKernelTestCase
{
    /**
     * @var NodeFactory
     */
    private $nodeFactory;
    protected function setUp() : void
    {
        $this->bootKernel(\Rector\Core\HttpKernel\RectorKernel::class);
        $this->nodeFactory = self::$container->get(\Rector\Core\PhpParser\Node\NodeFactory::class);
    }
    /**
     * @param mixed[] $inputArray
     * @dataProvider provideDataForArray()
     */
    public function testCreateArray(array $inputArray, \PhpParser\Node\Expr\Array_ $expectedArrayNode) : void
    {
        $arrayNode = $this->nodeFactory->createArray($inputArray);
        $this->assertEquals($expectedArrayNode, $arrayNode);
    }
    public function provideDataForArray() : \Iterator
    {
        $array = new \PhpParser\Node\Expr\Array_();
        $array->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\LNumber(1));
        (yield [[1], $array]);
        $array = new \PhpParser\Node\Expr\Array_();
        $array->items[] = new \PhpParser\Node\Expr\ArrayItem(new \PhpParser\Node\Scalar\LNumber(1), new \PhpParser\Node\Scalar\String_('a'));
        (yield [['a' => 1], $array]);
    }
}
