<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\MagicDisclosure\Rector\Assign;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\GetAndSetToMethodCallRectorTest
 */
final class GetAndSetToMethodCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const TYPE_TO_METHOD_CALLS = 'type_to_method_calls';
    /**
     * @var string[][]
     */
    private $typeToMethodCalls = [];
    /**
     * @var PropertyFetchManipulator
     */
    private $propertyFetchManipulator;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined `__get`/`__set` to specific method calls.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->someService = $someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->setService("someService", $someService);
CODE_SAMPLE
, [self::TYPE_TO_METHOD_CALLS => ['SomeContainer' => ['set' => 'addService']]]), new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
$someService = $container->someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$someService = $container->getService("someService");
CODE_SAMPLE
, [self::TYPE_TO_METHOD_CALLS => ['SomeContainer' => ['get' => 'getService']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param Assign|PropertyFetch $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign) {
            if ($node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch || $node->var instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
                return $this->processMagicSet($node);
            }
            return null;
        }
        return $this->processPropertyFetch($node);
    }
    public function configure(array $configuration) : void
    {
        $this->typeToMethodCalls = $configuration[self::TYPE_TO_METHOD_CALLS] ?? [];
    }
    private function processMagicSet(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetchNode, $objectType)) {
                continue;
            }
            return $this->createMethodCallNodeFromAssignNode($propertyFetchNode, $assign->expr, $transformation['set']);
        }
        return null;
    }
    private function processPropertyFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetch, $objectType)) {
                continue;
            }
            // setter, skip
            $parentNode = $propertyFetch->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Assign && $parentNode->var === $propertyFetch) {
                continue;
            }
            return $this->createMethodCallNodeFromPropertyFetchNode($propertyFetch, $transformation['get']);
        }
        return null;
    }
    private function shouldSkipPropertyFetch(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoper0a2ac50786fa\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$this->isObjectType($propertyFetch->var, $objectType)) {
            return \true;
        }
        if (!$this->propertyFetchManipulator->isMagicOnType($propertyFetch, $objectType)) {
            return \true;
        }
        return $this->propertyFetchManipulator->isPropertyToSelf($propertyFetch);
    }
    private function createMethodCallNodeFromAssignNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr $expr, string $method) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch), $expr]);
    }
    private function createMethodCallNodeFromPropertyFetchNode(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $method) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch)]);
    }
}
