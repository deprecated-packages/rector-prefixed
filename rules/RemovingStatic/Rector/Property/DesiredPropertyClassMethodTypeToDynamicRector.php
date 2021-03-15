<?php

declare (strict_types=1);
namespace Rector\RemovingStatic\Rector\Property;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PHPStan\Type\ObjectType;
use Rector\Core\Configuration\Option;
use Rector\Core\Rector\AbstractRector;
use RectorPrefix20210315\Symplify\PackageBuilder\Parameter\ParameterProvider;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\RemovingStatic\Rector\Property\DesiredPropertyClassMethodTypeToDynamicRector\DesiredPropertyClassMethodTypeToDynamicRectorTest
 */
final class DesiredPropertyClassMethodTypeToDynamicRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var ObjectType[]
     */
    private $staticObjectTypes = [];
    public function __construct(\RectorPrefix20210315\Symplify\PackageBuilder\Parameter\ParameterProvider $parameterProvider)
    {
        $typesToRemoveStaticFrom = $parameterProvider->provideArrayParameter(\Rector\Core\Configuration\Option::TYPES_TO_REMOVE_STATIC_FROM);
        foreach ($typesToRemoveStaticFrom as $typeToRemoveStaticFrom) {
            $this->staticObjectTypes[] = new \PHPStan\Type\ObjectType($typeToRemoveStaticFrom);
        }
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change defined static properties and methods to dynamic', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public static $name;

    public static function go()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class SomeClass
{
    public $name;

    public function go()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return class-string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Property::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param Property|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        foreach ($this->staticObjectTypes as $staticObjectType) {
            if (!$this->nodeNameResolver->isInClassNamed($node, $staticObjectType)) {
                continue;
            }
            if (!$node->isStatic()) {
                return null;
            }
            $this->visibilityManipulator->makeNonStatic($node);
            return $node;
        }
        return null;
    }
}
