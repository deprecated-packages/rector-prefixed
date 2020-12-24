<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\Property;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\Property\ChangePropertyVisibilityRector\ChangePropertyVisibilityRectorTest
 */
final class ChangePropertyVisibilityRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const PROPERTY_TO_VISIBILITY_BY_CLASS = 'propertyToVisibilityByClass';
    /**
     * @var string[][] { class => [ property name => visibility ] }
     */
    private $propertyToVisibilityByClass = [];
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change visibility of property from parent class.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class FrameworkClass
{
    protected $someProperty;
}

class MyClass extends FrameworkClass
{
    public $someProperty;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class FrameworkClass
{
    protected $someProperty;
}

class MyClass extends FrameworkClass
{
    protected $someProperty;
}
CODE_SAMPLE
, [self::PROPERTY_TO_VISIBILITY_BY_CLASS => ['FrameworkClass' => ['someProperty' => 'protected']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Property::class];
    }
    /**
     * @param Property $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        foreach ($this->propertyToVisibilityByClass as $type => $propertyToVisibility) {
            $classNode = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
            if ($classNode === null) {
                continue;
            }
            if (!$this->isObjectType($classNode, $type)) {
                continue;
            }
            foreach ($propertyToVisibility as $property => $visibility) {
                if (!$this->isName($node, $property)) {
                    continue;
                }
                $this->changeNodeVisibility($node, $visibility);
                return $node;
            }
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->propertyToVisibilityByClass = $configuration[self::PROPERTY_TO_VISIBILITY_BY_CLASS] ?? [];
    }
}
