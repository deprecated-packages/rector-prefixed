<?php

declare (strict_types=1);
namespace Rector\Generic\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Return_;
use PHPStan\Type\ArrayType;
use PHPStan\Type\MixedType;
use Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger;
use Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\ChangeContractMethodSingleToManyRectorTest
 */
final class ChangeContractMethodSingleToManyRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const OLD_TO_NEW_METHOD_BY_TYPE = 'old_to_new_method_by_type';
    /**
     * @var mixed[]
     */
    private $oldToNewMethodByType = [];
    /**
     * @var PhpDocTypeChanger
     */
    private $phpDocTypeChanger;
    public function __construct(\Rector\BetterPhpDocParser\PhpDocManipulator\PhpDocTypeChanger $phpDocTypeChanger)
    {
        $this->phpDocTypeChanger = $phpDocTypeChanger;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method that returns single value to multiple values', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var string $type */
        foreach ($this->oldToNewMethodByType as $type => $oldToNewMethod) {
            if (!$this->isObjectType($classLike, $type)) {
                continue;
            }
            foreach ($oldToNewMethod as $oldMethod => $newMethod) {
                if (!$this->isName($node, $oldMethod)) {
                    continue;
                }
                $node->name = new \PhpParser\Node\Identifier($newMethod);
                $this->keepOldReturnTypeInDocBlock($node);
                $node->returnType = new \PhpParser\Node\Identifier('array');
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
    private function keepOldReturnTypeInDocBlock(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // keep old return type in the docblock
        $oldReturnType = $classMethod->returnType;
        if ($oldReturnType === null) {
            return;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($oldReturnType);
        $arrayType = new \PHPStan\Type\ArrayType(new \PHPStan\Type\MixedType(), $staticType);
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($classMethod);
        $this->phpDocTypeChanger->changeReturnType($phpDocInfo, $arrayType);
    }
    private function wrapReturnValueToArray(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\PhpParser\Node $node) {
            if (!$node instanceof \PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $node->expr = $this->createArray([$node->expr]);
            return null;
        });
    }
}
