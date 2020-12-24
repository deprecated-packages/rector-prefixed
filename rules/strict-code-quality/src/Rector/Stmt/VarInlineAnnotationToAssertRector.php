<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\StrictCodeQuality\Rector\Stmt;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Instanceof_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType;
use _PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\StrictCodeQuality\Tests\Rector\Stmt\VarInlineAnnotationToAssertRector\VarInlineAnnotationToAssertRectorTest
 */
final class VarInlineAnnotationToAssertRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ASSERT = 'assert';
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turn @var inline checks above code to assert() of the type', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        /** @var SpecificClass $value */
        $value->call();
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
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
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt::class];
    }
    /**
     * @param Stmt $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        // skip properties
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property) {
            return null;
        }
        $phpDocInfo = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $docVariableName = $this->getVarDocVariableName($phpDocInfo);
        if ($docVariableName === null) {
            return null;
        }
        $variable = $this->findVariableByName($node, $docVariableName);
        if (!$variable instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $isVariableJustCreated = $this->isVariableJustCreated($node, $docVariableName);
        if (!$isVariableJustCreated) {
            return $this->refactorFreshlyCreatedNode($node, $phpDocInfo, $variable);
        }
        return $this->refactorAlreadyCreatedNode($node, $phpDocInfo, $variable);
    }
    private function getVarDocVariableName(\_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : ?string
    {
        $attributeAwareVarTagValueNode = $phpDocInfo->getVarTagValueNode();
        if ($attributeAwareVarTagValueNode === null) {
            return null;
        }
        $variableName = (string) $attributeAwareVarTagValueNode->variableName;
        // no variable
        if ($variableName === '') {
            return null;
        }
        return \ltrim($variableName, '$');
    }
    private function findVariableByName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt, string $docVariableName) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst($stmt, function (\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $stmt) use($docVariableName) : bool {
            return $this->isVariableName($stmt, $docVariableName);
        });
    }
    private function isVariableJustCreated(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt, string $docVariableName) : bool
    {
        if (!$stmt instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        if (!$stmt->expr instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        $assign = $stmt->expr;
        // the variable is on the left side = just created
        return $this->isVariableName($assign->var, $docVariableName);
    }
    private function refactorFreshlyCreatedNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $stmt->setAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        $type = $phpDocInfo->getVarType();
        $assertFuncCall = $this->createFuncCallBasedOnType($type, $variable);
        if ($assertFuncCall === null) {
            return null;
        }
        $phpDocInfo->removeByType(\_PhpScoper2a4e7ab1ecbc\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        $this->addNodeBeforeNode($assertFuncCall, $stmt);
        return $stmt;
    }
    private function refactorAlreadyCreatedNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt $stmt, \_PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        $varTagValue = $phpDocInfo->getVarTagValueNode();
        if ($varTagValue === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($varTagValue->type, $variable);
        $assertFuncCall = $this->createFuncCallBasedOnType($phpStanType, $variable);
        if ($assertFuncCall === null) {
            return null;
        }
        $this->addNodeAfterNode($assertFuncCall, $stmt);
        return $stmt;
    }
    private function createFuncCallBasedOnType(\_PhpScoper2a4e7ab1ecbc\PHPStan\Type\Type $type, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall
    {
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\ObjectType) {
            $instanceOf = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\Instanceof_($variable, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified($type->getClassName()));
            return $this->createFuncCall(self::ASSERT, [$instanceOf]);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\IntegerType) {
            $isInt = $this->createFuncCall('is_int', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isInt]);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\FloatType) {
            $funcCall = $this->createFuncCall('is_float', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$funcCall]);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\StringType) {
            $isString = $this->createFuncCall('is_string', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isString]);
        }
        if ($type instanceof \_PhpScoper2a4e7ab1ecbc\PHPStan\Type\BooleanType) {
            $isInt = $this->createFuncCall('is_bool', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isInt]);
        }
        return null;
    }
}
