<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\PHPStan\Type\UnionType;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector;
use _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
/**
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class AddMockPropertiesRector extends \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var PhpSpecMockCollector
     */
    private $phpSpecMockCollector;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\PhpSpecMockCollector $phpSpecMockCollector)
    {
        $this->phpSpecMockCollector = $phpSpecMockCollector;
        $this->classInsertManipulator = $classInsertManipulator;
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
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        $classMocks = $this->phpSpecMockCollector->resolveClassMocksFromParam($node);
        /** @var string $class */
        $class = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($classMocks as $name => $methods) {
            if ((\is_countable($methods) ? \count($methods) : 0) <= 1) {
                continue;
            }
            // non-ctor used mocks are probably local only
            if (!\in_array('let', $methods, \true)) {
                continue;
            }
            $this->phpSpecMockCollector->addPropertyMock($class, $name);
            $variableType = $this->phpSpecMockCollector->getTypeForClassAndVariable($node, $name);
            $unionType = new \_PhpScopere8e811afab72\PHPStan\Type\UnionType([new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($variableType), new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType('_PhpScopere8e811afab72\\PHPUnit\\Framework\\MockObject\\MockObject')]);
            $this->classInsertManipulator->addPropertyToClass($node, $name, $unionType);
        }
        return null;
    }
}
