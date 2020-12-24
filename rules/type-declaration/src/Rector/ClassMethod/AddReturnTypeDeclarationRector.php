<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\TypeDeclaration\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\ArrayType;
use _PhpScoper0a6b37af0871\PHPStan\Type\MixedType;
use _PhpScoper0a6b37af0871\PHPStan\Type\Type;
use _PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Webmozart\Assert\Assert;
/**
 * @see \Rector\TypeDeclaration\Tests\Rector\ClassMethod\AddReturnTypeDeclarationRector\AddReturnTypeDeclarationRectorTest
 */
final class AddReturnTypeDeclarationRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector implements \_PhpScoper0a6b37af0871\Rector\Core\Contract\Rector\ConfigurableRectorInterface
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
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PHPStan\TypeComparator $typeComparator)
    {
        $this->typeComparator = $typeComparator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        $arrayType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ArrayType(new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType(), new \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType());
        $configuration = [self::METHOD_RETURN_TYPES => [new \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration('SomeClass', 'getData', $arrayType)]];
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Changes defined return typehint of method and class.', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
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
        \_PhpScoper0a6b37af0871\Webmozart\Assert\Assert::allIsInstanceOf($methodReturnTypes, \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\ValueObject\AddReturnTypeDeclaration::class);
        $this->methodReturnTypes = $methodReturnTypes;
    }
    private function processClassMethodNodeWithTypehints(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a6b37af0871\PHPStan\Type\Type $newType) : void
    {
        // remove it
        if ($newType instanceof \_PhpScoper0a6b37af0871\PHPStan\Type\MixedType) {
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
