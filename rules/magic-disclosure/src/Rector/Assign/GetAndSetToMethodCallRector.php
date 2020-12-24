<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\MagicDisclosure\Rector\Assign;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\GetAndSetToMethodCallRectorTest
 */
final class GetAndSetToMethodCallRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined `__get`/`__set` to specific method calls.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->someService = $someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->setService("someService", $someService);
CODE_SAMPLE
, [self::TYPE_TO_METHOD_CALLS => ['SomeContainer' => ['set' => 'addService']]]), new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param Assign|PropertyFetch $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            if ($node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch) {
                return $this->processMagicSet($node);
            }
            if ($node->var instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticPropertyFetch) {
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
    private function processMagicSet(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetchNode, $objectType)) {
                continue;
            }
            return $this->createMethodCallNodeFromAssignNode($propertyFetchNode, $assign->expr, $transformation['set']);
        }
        return null;
    }
    private function processPropertyFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetch, $objectType)) {
                continue;
            }
            // setter, skip
            $parentNode = $propertyFetch->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign && $parentNode->var === $propertyFetch) {
                continue;
            }
            return $this->createMethodCallNodeFromPropertyFetchNode($propertyFetch, $transformation['get']);
        }
        return null;
    }
    private function shouldSkipPropertyFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$this->isObjectType($propertyFetch->var, $objectType)) {
            return \true;
        }
        if (!$this->propertyFetchManipulator->isMagicOnType($propertyFetch, $objectType)) {
            return \true;
        }
        return $this->propertyFetchManipulator->isPropertyToSelf($propertyFetch);
    }
    private function createMethodCallNodeFromAssignNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr $expr, string $method) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch), $expr]);
    }
    private function createMethodCallNodeFromPropertyFetchNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $method) : \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch)]);
    }
}
