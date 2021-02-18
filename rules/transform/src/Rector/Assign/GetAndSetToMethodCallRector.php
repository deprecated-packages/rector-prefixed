<?php

declare (strict_types=1);
namespace Rector\Transform\Rector\Assign;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PHPStan\Type\ObjectType;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer;
use Rector\Core\NodeManipulator\MagicPropertyFetchAnalyzer;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Transform\Tests\Rector\Assign\GetAndSetToMethodCallRector\GetAndSetToMethodCallRectorTest
 */
final class GetAndSetToMethodCallRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
     * @var PropertyFetchAnalyzer
     */
    private $propertyFetchAnalyzer;
    /**
     * @var MagicPropertyFetchAnalyzer
     */
    private $magicPropertyFetchAnalyzer;
    public function __construct(\Rector\Core\NodeAnalyzer\PropertyFetchAnalyzer $propertyFetchAnalyzer, \Rector\Core\NodeManipulator\MagicPropertyFetchAnalyzer $magicPropertyFetchAnalyzer)
    {
        $this->propertyFetchAnalyzer = $propertyFetchAnalyzer;
        $this->magicPropertyFetchAnalyzer = $magicPropertyFetchAnalyzer;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns defined `__get`/`__set` to specific method calls.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->someService = $someService;
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$container = new SomeContainer;
$container->setService("someService", $someService);
CODE_SAMPLE
, [self::TYPE_TO_METHOD_CALLS => ['SomeContainer' => ['set' => 'addService']]]), new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Expr\Assign::class, \PhpParser\Node\Expr\PropertyFetch::class];
    }
    /**
     * @param Assign|PropertyFetch $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($node instanceof \PhpParser\Node\Expr\Assign) {
            if (\Rector\Core\Util\StaticInstanceOf::isOneOf($node->var, [\PhpParser\Node\Expr\PropertyFetch::class, \PhpParser\Node\Expr\StaticPropertyFetch::class])) {
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
    private function processMagicSet(\PhpParser\Node\Expr\Assign $assign) : ?\PhpParser\Node
    {
        /** @var PropertyFetch $propertyFetchNode */
        $propertyFetchNode = $assign->var;
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetchNode, $objectType)) {
                continue;
            }
            return $this->createMethodCallNodeFromAssignNode($propertyFetchNode, $assign->expr, $transformation['set']);
        }
        return null;
    }
    private function processPropertyFetch(\PhpParser\Node\Expr\PropertyFetch $propertyFetch) : ?\PhpParser\Node\Expr\MethodCall
    {
        foreach ($this->typeToMethodCalls as $type => $transformation) {
            $objectType = new \PHPStan\Type\ObjectType($type);
            if ($this->shouldSkipPropertyFetch($propertyFetch, $objectType)) {
                continue;
            }
            // setter, skip
            $parentNode = $propertyFetch->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
            if ($parentNode instanceof \PhpParser\Node\Expr\Assign && $parentNode->var === $propertyFetch) {
                continue;
            }
            return $this->createMethodCallNodeFromPropertyFetchNode($propertyFetch, $transformation['get']);
        }
        return null;
    }
    private function shouldSkipPropertyFetch(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \PHPStan\Type\ObjectType $objectType) : bool
    {
        if (!$this->isObjectType($propertyFetch->var, $objectType)) {
            return \true;
        }
        if (!$this->magicPropertyFetchAnalyzer->isMagicOnType($propertyFetch, $objectType)) {
            return \true;
        }
        return $this->propertyFetchAnalyzer->isPropertyToSelf($propertyFetch);
    }
    private function createMethodCallNodeFromAssignNode(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, \PhpParser\Node\Expr $expr, string $method) : \PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->nodeFactory->createMethodCall($variableNode, $method, [$this->getName($propertyFetch), $expr]);
    }
    private function createMethodCallNodeFromPropertyFetchNode(\PhpParser\Node\Expr\PropertyFetch $propertyFetch, string $method) : \PhpParser\Node\Expr\MethodCall
    {
        /** @var Variable $variableNode */
        $variableNode = $propertyFetch->var;
        return $this->nodeFactory->createMethodCall($variableNode, $method, [$this->getName($propertyFetch)]);
    }
}
