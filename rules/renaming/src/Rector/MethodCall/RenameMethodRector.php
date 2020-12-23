<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Renaming\Rector\MethodCall;

use _PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassLike;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename;
use _PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\RenameMethodRectorTest
 */
final class RenameMethodRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_RENAMES = 'method_call_renames';
    /**
     * @var MethodCallRenameInterface[]
     */
    private $methodCallRenames = [];
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns method names to new ones.', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->oldMethod();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->newMethod();
CODE_SAMPLE
, [self::METHOD_CALL_RENAMES => [new \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRename('SomeExampleClass', 'oldMethod', 'newMethod')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        foreach ($this->methodCallRenames as $methodCallRename) {
            if (!$this->isMethodStaticCallOrClassMethodObjectType($node, $methodCallRename->getOldClass())) {
                continue;
            }
            if (!$this->isName($node->name, $methodCallRename->getOldMethod())) {
                continue;
            }
            if ($this->skipClassMethod($node, $methodCallRename)) {
                continue;
            }
            $node->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($methodCallRename->getNewMethod());
            if ($methodCallRename instanceof \_PhpScoper0a2ac50786fa\Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey && !$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
                return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\ArrayDimFetch($node, \_PhpScoper0a2ac50786fa\PhpParser\BuilderHelpers::normalizeValue($methodCallRename->getArrayKey()));
            }
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodCallRenames = $configuration[self::METHOD_CALL_RENAMES] ?? [];
        \_PhpScoper0a2ac50786fa\Webmozart\Assert\Assert::allIsInstanceOf($methodCallRenames, \_PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface::class);
        $this->methodCallRenames = $methodCallRenames;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function skipClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, \_PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface $methodCallRename) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        if ($this->shouldSkipForAlreadyExistingClassMethod($node, $methodCallRename)) {
            return \true;
        }
        return $this->shouldSkipForExactClassMethodForClassMethod($node, $methodCallRename->getOldClass());
    }
    private function shouldSkipForAlreadyExistingClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\Rector\Renaming\Contract\MethodCallRenameInterface $methodCallRename) : bool
    {
        if (!$classMethod instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        /** @var ClassLike|null $classLike */
        $classLike = $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classLike === null) {
            return \false;
        }
        return (bool) $classLike->getMethod($methodCallRename->getNewMethod());
    }
    private function shouldSkipForExactClassMethodForClassMethod(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return $classMethod->getAttribute(\_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME) === $type;
    }
}
