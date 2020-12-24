<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Generic\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Generic\Tests\Rector\ClassMethod\ChangeContractMethodSingleToManyRector\ChangeContractMethodSingleToManyRectorTest
 */
final class ChangeContractMethodSingleToManyRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change method that returns single value to multiple values', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        /** @var Class_ $classLike */
        $classLike = $node->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        /** @var string $type */
        foreach ($this->oldToNewMethodByType as $type => $oldToNewMethod) {
            if (!$this->isObjectType($classLike, $type)) {
                continue;
            }
            foreach ($oldToNewMethod as $oldMethod => $newMethod) {
                if (!$this->isName($node, $oldMethod)) {
                    continue;
                }
                $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier($newMethod);
                $this->keepOldReturnTypeInDocBlock($node);
                $node->returnType = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier('array');
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
    private function keepOldReturnTypeInDocBlock(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // keep old return type in the docblock
        $oldReturnType = $classMethod->returnType;
        if ($oldReturnType === null) {
            return;
        }
        $staticType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($oldReturnType);
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), $staticType);
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->changeReturnType($arrayType);
    }
    private function wrapReturnValueToArray(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Return_) {
                return null;
            }
            $node->expr = $this->createArray([$node->expr]);
            return null;
        });
    }
}
