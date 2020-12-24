<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PHPStan\Type\ArrayType;
use _PhpScopere8e811afab72\PHPStan\Type\MixedType;
use _PhpScopere8e811afab72\PHPStan\Type\Type;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScopere8e811afab72\Webmozart\Assert\Assert;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\AddReturnTypeDeclarationRectorTest
 */
final class AddReturnTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @var string
     */
    public const METHOD_RETURN_TYPES = 'method_return_types';
    /**
     * @var AddReturnTypeDeclaration[]
     */
    private $methodReturnTypes = [];
    /**
     * @var TypeComparator
     */
    private $typeComparator;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $arrayType = new \_PhpScopere8e811afab72\PHPStan\Type\ArrayType(new \_PhpScopere8e811afab72\PHPStan\Type\MixedType(), new \_PhpScopere8e811afab72\PHPStan\Type\MixedType());
        $configuration = [self::METHOD_RETURN_TYPES => [new \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('SomeClass', 'getData', $arrayType)]];
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes defined return typehint of method and class.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public getData()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public getData(): array
    {
    }
}
CODE_SAMPLE
, $configuration)]);
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
        foreach ($this->methodReturnTypes as $methodReturnType) {
            if (!$this->isObjectType($node, $methodReturnType->getClass())) {
                continue;
            }
            if (!$this->isName($node, $methodReturnType->getMethod())) {
                continue;
            }
            $this->processClassMethodNodeWithTypehints($node, $methodReturnType->getReturnType());
            return $node;
        }
        return null;
    }
    public function configure(array $configuration) : void
    {
        $methodReturnTypes = $configuration[self::METHOD_RETURN_TYPES] ?? [];
        \_PhpScopere8e811afab72\Webmozart\Assert\Assert::allIsInstanceOf($methodReturnTypes, \_PhpScopere8e811afab72\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration::class);
        $this->methodReturnTypes = $methodReturnTypes;
    }
    private function processClassMethodNodeWithTypehints(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScopere8e811afab72\PHPStan\Type\Type $newType) : void
    {
        // remove it
        if ($newType instanceof \_PhpScopere8e811afab72\PHPStan\Type\MixedType) {
            $classMethod->returnType = null;
            return;
        }
        // already set → no change
        if ($classMethod->returnType !== null) {
            $currentReturnType = $this->staticTypeMapper->mapPhpParserNodePHPStanType($classMethod->returnType);
            if ($this->typeComparator->areTypesEqual($currentReturnType, $newType)) {
                return;
            }
        }
        $returnTypeNode = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($newType);
        $classMethod->returnType = $returnTypeNode;
    }
}
