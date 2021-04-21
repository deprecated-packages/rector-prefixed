<?php

declare(strict_types=1);

namespace Rector\CodeQualityStrict\Rector\Stmt;

use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\Instanceof_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Property;
use PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use PHPStan\Type\BooleanType;
use PHPStan\Type\FloatType;
use PHPStan\Type\IntegerType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

/**
 * @see \Rector\Tests\CodeQualityStrict\Rector\Stmt\VarInlineAnnotationToAssertRector\VarInlineAnnotationToAssertRectorTest
 */
final class VarInlineAnnotationToAssertRector extends AbstractRector
{
    /**
     * @var string
     */
    const ASSERT = 'assert';

    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Turn @var inline checks above code to assert() of the type',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        /** @var SpecificClass $value */
        $value->call();
    }
}
CODE_SAMPLE
                    ,
                    <<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        /** @var SpecificClass $value */
        assert($value instanceof SpecificClass);
        $value->call();
    }
}
CODE_SAMPLE
            ),
            ]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Stmt::class];
    }

    /**
     * @param Stmt $node
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node)
    {
        // skip properties
        if ($node instanceof Property) {
            return null;
        }

        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($node);

        $docVariableName = $this->getVarDocVariableName($phpDocInfo);
        if ($docVariableName === null) {
            return null;
        }

        $variable = $this->findVariableByName($node, $docVariableName);
        if (! $variable instanceof Variable) {
            return null;
        }

        $isVariableJustCreated = $this->isVariableJustCreated($node, $docVariableName);
        if (! $isVariableJustCreated) {
            return $this->refactorFreshlyCreatedNode($node, $phpDocInfo, $variable);
        }

        return $this->refactorAlreadyCreatedNode($node, $phpDocInfo, $variable);
    }

    /**
     * @return string|null
     */
    private function getVarDocVariableName(PhpDocInfo $phpDocInfo)
    {
        $varTagValueNode = $phpDocInfo->getVarTagValueNode();
        if (! $varTagValueNode instanceof VarTagValueNode) {
            return null;
        }

        $variableName = $varTagValueNode->variableName;
        // no variable
        if ($variableName === '') {
            return null;
        }

        return ltrim($variableName, '$');
    }

    /**
     * @return \PhpParser\Node|null
     */
    private function findVariableByName(Stmt $stmt, string $docVariableName)
    {
        return $this->betterNodeFinder->findFirst($stmt, function (Node $node) use ($docVariableName): bool {
            if (! $node instanceof Variable) {
                return false;
            }

            return $this->nodeNameResolver->isName($node, $docVariableName);
        });
    }

    private function isVariableJustCreated(Stmt $stmt, string $docVariableName): bool
    {
        if (! $stmt instanceof Expression) {
            return false;
        }

        if (! $stmt->expr instanceof Assign) {
            return false;
        }

        $assign = $stmt->expr;
        if (! $assign->var instanceof Variable) {
            return false;
        }

        // the variable is on the left side = just created
        return $this->nodeNameResolver->isName($assign->var, $docVariableName);
    }

    /**
     * @return \PhpParser\Node|null
     */
    private function refactorFreshlyCreatedNode(Stmt $stmt, PhpDocInfo $phpDocInfo, Variable $variable)
    {
        $stmt->setAttribute(AttributeKey::COMMENTS, null);
        $type = $phpDocInfo->getVarType();

        $assertFuncCall = $this->createFuncCallBasedOnType($type, $variable);
        if (! $assertFuncCall instanceof FuncCall) {
            return null;
        }

        $phpDocInfo->removeByType(VarTagValueNode::class);

        $this->addNodeBeforeNode($assertFuncCall, $stmt);

        return $stmt;
    }

    /**
     * @return \PhpParser\Node|null
     */
    private function refactorAlreadyCreatedNode(Stmt $stmt, PhpDocInfo $phpDocInfo, Variable $variable)
    {
        $varTagValue = $phpDocInfo->getVarTagValueNode();
        if (! $varTagValue instanceof VarTagValueNode) {
            throw new ShouldNotHappenException();
        }

        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType(
            $varTagValue->type,
            $variable
        );

        $assertFuncCall = $this->createFuncCallBasedOnType($phpStanType, $variable);
        if (! $assertFuncCall instanceof FuncCall) {
            return null;
        }

        $this->addNodeAfterNode($assertFuncCall, $stmt);

        return $stmt;
    }

    /**
     * @return \PhpParser\Node\Expr\FuncCall|null
     */
    private function createFuncCallBasedOnType(Type $type, Variable $variable)
    {
        if ($type instanceof ObjectType) {
            $instanceOf = new Instanceof_($variable, new FullyQualified($type->getClassName()));
            return $this->nodeFactory->createFuncCall(self::ASSERT, [$instanceOf]);
        }

        if ($type instanceof IntegerType) {
            $isInt = $this->nodeFactory->createFuncCall('is_int', [$variable]);
            return $this->nodeFactory->createFuncCall(self::ASSERT, [$isInt]);
        }

        if ($type instanceof FloatType) {
            $funcCall = $this->nodeFactory->createFuncCall('is_float', [$variable]);
            return $this->nodeFactory->createFuncCall(self::ASSERT, [$funcCall]);
        }

        if ($type instanceof StringType) {
            $isString = $this->nodeFactory->createFuncCall('is_string', [$variable]);
            return $this->nodeFactory->createFuncCall(self::ASSERT, [$isString]);
        }

        if ($type instanceof BooleanType) {
            $isInt = $this->nodeFactory->createFuncCall('is_bool', [$variable]);
            return $this->nodeFactory->createFuncCall(self::ASSERT, [$isInt]);
        }

        return null;
    }
}
