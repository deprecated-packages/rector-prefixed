<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/sebastianbergmann/phpunit/issues/4142
 * @see https://github.com/sebastianbergmann/phpunit/issues/4141
 * @see https://github.com/sebastianbergmann/phpunit/issues/4149
 *
 * @see \Rector\PHPUnit\Tests\Rector\Class_\AddProphecyTraitRector\AddProphecyTraitRectorTest
 */
final class AddProphecyTraitRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var string
     */
    private const PROPHECY_TRAIT = '_PhpScopere8e811afab72\\Prophecy\\PhpUnit\\ProphecyTrait';
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @var ClassManipulator
     */
    private $classManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassManipulator $classManipulator)
    {
        $this->classInsertManipulator = $classInsertManipulator;
        $this->classManipulator = $classManipulator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add Prophecy trait for method using $this->prophesize()', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

final class ExampleTest extends TestCase
{
    public function testOne(): void
    {
        $prophecy = $this->prophesize(\AnInterface::class);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

final class ExampleTest extends TestCase
{
    use ProphecyTrait;

    public function testOne(): void
    {
        $prophecy = $this->prophesize(\AnInterface::class);
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkipClass($node)) {
            return null;
        }
        $this->classInsertManipulator->addAsFirstTrait($node, self::PROPHECY_TRAIT);
        return $node;
    }
    private function shouldSkipClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->isInTestClass($class)) {
            return \true;
        }
        $hasProphesizeMethodCall = $this->hasProphesizeMethodCall($class);
        if (!$hasProphesizeMethodCall) {
            return \true;
        }
        return $this->classManipulator->hasTrait($class, self::PROPHECY_TRAIT);
    }
    private function hasProphesizeMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst($class, function (\_PhpScopere8e811afab72\PhpParser\Node $class) : bool {
            return $this->isMethodCall($class, 'this', 'prophesize');
        });
    }
}
