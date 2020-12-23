<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Generic\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\AddMethodParentCallRector\AddMethodParentCallRectorTest
 */
final class AddMethodParentCallRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHODS_BY_PARENT_TYPES = 'methods_by_parent_type';
    /**
     * @var array<string, string>
     */
    private $methodsByParentTypes = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Add method parent call, in case new parent method is added', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SunshineCommand extends ParentClassWithNewConstructor
{
    public function __construct()
    {
        $value = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SunshineCommand extends ParentClassWithNewConstructor
{
    public function __construct()
    {
        $value = 5;

        parent::__construct();
    }
}
CODE_SAMPLE
, [self::METHODS_BY_PARENT_TYPES => ['ParentClassWithNewConstructor' => '__construct']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return null;
        }
        /** @var string $className */
        $className = $node->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        foreach ($this->methodsByParentTypes as $type => $method) {
            if (!$this->isObjectType($classLike, $type)) {
                continue;
            }
            // not itself
            if ($className === $type) {
                continue;
            }
            if ($this->shouldSkipMethod($node, $method)) {
                continue;
            }
            $node->stmts[] = $this->createParentStaticCall($method);
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $this->methodsByParentTypes = $configuration[self::METHODS_BY_PARENT_TYPES] ?? [];
    }
    private function shouldSkipMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $method) : bool
    {
        if (!$this->isName($classMethod, $method)) {
            return \true;
        }
        return $this->hasParentCallOfMethod($classMethod, $method);
    }
    private function createParentStaticCall(string $method) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression
    {
        $staticCall = $this->createStaticCall('parent', $method);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($staticCall);
    }
    /**
     * Looks for "parent::<methodName>
     */
    private function hasParentCallOfMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $method) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) use($method) : bool {
            return $this->isStaticCallNamed($node, 'parent', $method);
        });
    }
}
