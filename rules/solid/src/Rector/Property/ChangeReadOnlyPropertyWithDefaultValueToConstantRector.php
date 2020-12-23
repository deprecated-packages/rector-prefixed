<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\SOLID\Rector\Property;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Const_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\SOLID\Tests\Rector\Property\ChangeReadOnlyPropertyWithDefaultValueToConstantRector\ChangeReadOnlyPropertyWithDefaultValueToConstantRectorTest
 */
final class ChangeReadOnlyPropertyWithDefaultValueToConstantRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PropertyManipulator
     */
    private $propertyManipulator;
    /**
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyManipulator $propertyManipulator, \_PhpScoper0a2ac50786fa\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer)
    {
        $this->propertyManipulator = $propertyManipulator;
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change property with read only status with default value to constant', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string[]
     */
    private $magicMethods = [
        '__toString',
        '__wakeup',
    ];

    public function run()
    {
        foreach ($this->magicMethods as $magicMethod) {
            echo $magicMethod;
        }
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @var string[]
     */
    private const MAGIC_METHODS = [
        '__toString',
        '__wakeup',
    ];

    public function run()
    {
        foreach (self::MAGIC_METHODS as $magicMethod) {
            echo $magicMethod;
        }
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var PropertyProperty $onlyProperty */
        $onlyProperty = $node->props[0];
        // we need default value
        if ($onlyProperty->default === null) {
            return null;
        }
        if (!$node->isPrivate()) {
            return null;
        }
        // is property read only?
        if ($this->propertyManipulator->isPropertyChangeable($node)) {
            return null;
        }
        $this->replacePropertyFetchWithClassConstFetch($node, $onlyProperty);
        return $this->createClassConst($node, $onlyProperty);
    }
    private function shouldSkip(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property) : bool
    {
        if (\count((array) $property->props) !== 1) {
            return \true;
        }
        $classLike = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
            return \true;
        }
        return $this->isObjectType($classLike, '_PhpScoper0a2ac50786fa\\PHP_CodeSniffer\\Sniffs\\Sniff');
    }
    private function replacePropertyFetchWithClassConstFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : void
    {
        $classLike = $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        $propertyName = $this->getName($propertyProperty);
        $constantName = $this->createConstantNameFromProperty($propertyProperty);
        $this->traverseNodesWithCallable($classLike, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($propertyName, $constantName) : ?ClassConstFetch {
            if (!$this->propertyFetchAnalyzer->isLocalPropertyFetch($node)) {
                return null;
            }
            /** @var PropertyFetch|StaticPropertyFetch $node */
            if (!$this->isName($node->name, $propertyName)) {
                return null;
            }
            // replace with constant fetch
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ClassConstFetch(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name('self'), $constantName);
        });
    }
    private function createClassConst(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Property $property, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst
    {
        $constantName = $this->createConstantNameFromProperty($propertyProperty);
        /** @var Expr $defaultValue */
        $defaultValue = $propertyProperty->default;
        $const = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Const_($constantName, $defaultValue);
        $classConst = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassConst([$const]);
        $classConst->flags = $property->flags & ~\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::MODIFIER_STATIC;
        $classConst->setAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO, $property->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO));
        return $classConst;
    }
    private function createConstantNameFromProperty(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\PropertyProperty $propertyProperty) : string
    {
        $propertyName = $this->getName($propertyProperty);
        $constantName = \_PhpScoper0a2ac50786fa\Rector\Core\Util\StaticRectorStrings::camelCaseToUnderscore($propertyName);
        return \strtoupper($constantName);
    }
}
