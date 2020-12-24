<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\MagicDisclosure\Rector\Assign;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\MagicDisclosure\Tests\Rector\Assign\GetAndSetToMethodCallRector\GetAndSetToMethodCallRectorTest
 */
final class GetAndSetToMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector implements \_PhpScoperb75b35f52b74\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoperb75b35f52b74\Rector\Core\PhpParser\Node\Manipulator\PropertyFetchManipulator $propertyFetchManipulator)
    {
        $this->propertyFetchManipulator = $propertyFetchManipulator;
    }
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined `__get`/`__set` to specific method calls.', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->someService = $someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->setService("someService", $someService);
CODE_SAMPLE
, [self::TYPE_TO_METHOD_CALLS => ['SomeContainer' => ['set' => 'addService']]]), new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign::class, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param Assign|PropertyFetch $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            if ($node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch || $node->var instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticPropertyFetch) {
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
    private function processMagicSet(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign $assign) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetchNode, $objectType)) {
                continue;
            }
            return $this->createMethodCallNodeFromAssignNode($propertyFetchNode, $assign->expr, $transformation['set']);
        }
        return null;
    }
    private function processPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetch, $objectType)) {
                continue;
            }
            // setter, skip
            $parentNode = $propertyFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign && $parentNode->var === $propertyFetch) {
                continue;
            }
            return $this->createMethodCallNodeFromPropertyFetchNode($propertyFetch, $transformation['get']);
        }
        return null;
    }
    private function shouldSkipPropertyFetch(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$this->isObjectType($propertyFetch->var, $objectType)) {
            return \true;
        }
        if (!$this->propertyFetchManipulator->isMagicOnType($propertyFetch, $objectType)) {
            return \true;
        }
        return $this->propertyFetchManipulator->isPropertyToSelf($propertyFetch);
    }
    private function createMethodCallNodeFromAssignNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr $expr, string $method) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch), $expr]);
    }
    private function createMethodCallNodeFromPropertyFetchNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $method) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->createMethodCall($variableNode, $method, [$this->getName($propertyFetch)]);
    }
}
