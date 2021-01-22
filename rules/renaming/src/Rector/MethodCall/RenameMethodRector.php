<?php

declare (strict_types=1);
namespace Rector\Renaming\Rector\MethodCall;

use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\Node\Expr\ArrayDimFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\Renaming\Contract\MethodCallRenameInterface;
use Rector\Renaming\ValueObject\MethodCallRename;
use Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210122\Webmozart\Assert\Assert;
/**
 * @see \Rector\Renaming\Tests\Rector\MethodCall\RenameMethodRector\RenameMethodRectorTest
 */
final class RenameMethodRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_CALL_RENAMES = 'method_call_renames';
    /**
     * @var MethodCallRenameInterface[]
     */
    private $methodCallRenames = [];
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns method names to new ones.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->oldMethod();
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$someObject = new SomeExampleClass;
$someObject->newMethod();
CODE_SAMPLE
, [self::METHOD_CALL_RENAMES => [new \Rector\Renaming\ValueObject\MethodCallRename('SomeExampleClass', 'oldMethod', 'newMethod')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
            $node->name = new \PhpParser\Node\Identifier($methodCallRename->getNewMethod());
            if ($methodCallRename instanceof \Rector\Renaming\ValueObject\MethodCallRenameWithArrayKey && !$node instanceof \PhpParser\Node\Stmt\ClassMethod) {
                return new \PhpParser\Node\Expr\ArrayDimFetch($node, \PhpParser\BuilderHelpers::normalizeValue($methodCallRename->getArrayKey()));
            }
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodCallRenames = $configuration[self::METHOD_CALL_RENAMES] ?? [];
        \RectorPrefix20210122\Webmozart\Assert\Assert::allIsInstanceOf($methodCallRenames, \Rector\Renaming\Contract\MethodCallRenameInterface::class);
        $this->methodCallRenames = $methodCallRenames;
    }
    /**
     * @param MethodCall|StaticCall|ClassMethod $node
     */
    private function skipClassMethod(\PhpParser\Node $node, \Rector\Renaming\Contract\MethodCallRenameInterface $methodCallRename) : bool
    {
        if (!$node instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        if ($this->shouldSkipForAlreadyExistingClassMethod($node, $methodCallRename)) {
            return \true;
        }
        return $this->shouldSkipForExactClassMethodForClassMethod($node, $methodCallRename->getOldClass());
    }
    private function shouldSkipForAlreadyExistingClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, \Rector\Renaming\Contract\MethodCallRenameInterface $methodCallRename) : bool
    {
        if (!$classMethod instanceof \PhpParser\Node\Stmt\ClassMethod) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\ClassLike) {
            return \false;
        }
        return (bool) $classLike->getMethod($methodCallRename->getNewMethod());
    }
    private function shouldSkipForExactClassMethodForClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod, string $type) : bool
    {
        return $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME) === $type;
    }
}
