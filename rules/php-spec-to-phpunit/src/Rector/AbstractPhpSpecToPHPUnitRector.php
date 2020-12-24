<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://gnugat.github.io/2015/09/23/phpunit-with-phpspec.html
 * @see http://www.phpspec.net/en/stable/cookbook/construction.html
 */
abstract class AbstractPhpSpecToPHPUnitRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Migrate PhpSpec behavior to PHPUnit test', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'

namespace spec\SomeNamespaceForThisTest;

use PhpSpec\ObjectBehavior;

class OrderSpec extends ObjectBehavior
{
    public function let(OrderFactory $factory, ShippingMethod $shippingMethod): void
    {
        $factory->createShippingMethodFor(Argument::any())->shouldBeCalled()->willReturn($shippingMethod);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
namespace spec\SomeNamespaceForThisTest;

class OrderSpec extends ObjectBehavior
{
    /**
     * @var \SomeNamespaceForThisTest\Order
     */
    private $order;
    protected function setUp()
    {
        /** @var OrderFactory|\PHPUnit\Framework\MockObject\MockObject $factory */
        $factory = $this->createMock(OrderFactory::class);

        /** @var ShippingMethod|\PHPUnit\Framework\MockObject\MockObject $shippingMethod */
        $shippingMethod = $this->createMock(ShippingMethod::class);

        $factory->expects($this->once())->method('createShippingMethodFor')->willReturn($shippingMethod);
    }
}
CODE_SAMPLE
)]);
    }
    public function isInPhpSpecBehavior(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return $this->isObjectType($classLike, '_PhpScopere8e811afab72\\PhpSpec\\ObjectBehavior');
    }
}
