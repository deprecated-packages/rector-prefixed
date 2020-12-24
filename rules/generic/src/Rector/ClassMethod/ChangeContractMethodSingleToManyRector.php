<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Generic\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\ChangeContractMethodSingleToManyRectorTest
 */
final class ChangeContractMethodSingleToManyRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const OLD_TO_NEW_METHOD_BY_TYPE = '$oldToNewMethodByType';
    /**
     * @var mixed[]
     */
    private $oldToNewMethodByType = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method that returns single value to multiple values', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function getNode(): string
    {
        return 'Echo_';
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @return string[]
     */
    public function getNodes(): array
    {
        return ['Echo_'];
    }
}
CODE_SAMPLE
, [self::OLD_TO_NEW_METHOD_BY_TYPE => ['SomeClass' => ['getNode' => 'getNodes']]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var string $type */
        foreach ($this->oldToNewMethodByType as $type => $oldToNewMethod) {
            if (!$this->isObjectType($classLike, $type)) {
                continue;
            }
            foreach ($oldToNewMethod as $oldMethod => $newMethod) {
                if (!$this->isName($node, $oldMethod)) {
                    continue;
                }
                $node->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newMethod);
                $this->keepOldReturnTypeInDocBlock($node);
                $node->returnType = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('array');
                $this->wrapReturnValueToArray($node);
                break;
            }
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->oldToNewMethodByType = $configuration[self::OLD_TO_NEW_METHOD_BY_TYPE] ?? [];
    }
    private function keepOldReturnTypeInDocBlock(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // keep old return type in the docblock
        $oldReturnType = $classMethod->returnType;
        if ($oldReturnType === null) {
            return;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($oldReturnType);
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), $staticType);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeReturnType($arrayType);
    }
    private function wrapReturnValueToArray(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScopere8e811afab72\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $node->expr = $this->createArray([$node->expr]);
            return null;
        });
    }
}
