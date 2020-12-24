<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\StrictCodeQuality\Rector\Stmt;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property;
use _PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode;
use _PhpScoperb75b35f52b74\PHPStan\Type\BooleanType;
use _PhpScoperb75b35f52b74\PHPStan\Type\FloatType;
use _PhpScoperb75b35f52b74\PHPStan\Type\IntegerType;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\PHPStan\Type\StringType;
use _PhpScoperb75b35f52b74\PHPStan\Type\Type;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\StrictCodeQuality\Tests\Rector\Stmt\VarInlineAnnotationToAssertRector\VarInlineAnnotationToAssertRectorTest
 */
final class VarInlineAnnotationToAssertRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const ASSERT = 'assert';
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turn @var inline checks above code to assert() of the type', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt::class];
    }
    /**
     * @param Stmt $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        // skip properties
        if ($node instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Property) {
            return null;
        }
        $phpDocInfo = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return null;
        }
        $docVariableName = $this->getVarDocVariableName($phpDocInfo);
        if ($docVariableName === null) {
            return null;
        }
        $variable = $this->findVariableByName($node, $docVariableName);
        if (!$variable instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable) {
            return null;
        }
        $isVariableJustCreated = $this->isVariableJustCreated($node, $docVariableName);
        if (!$isVariableJustCreated) {
            return $this->refactorFreshlyCreatedNode($node, $phpDocInfo, $variable);
        }
        return $this->refactorAlreadyCreatedNode($node, $phpDocInfo, $variable);
    }
    private function getVarDocVariableName(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo) : ?string
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
    private function findVariableByName(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt, string $docVariableName) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirst($stmt, function (\_PhpScoperb75b35f52b74\PhpParser\Node $stmt) use($docVariableName) : bool {
            return $this->isVariableName($stmt, $docVariableName);
        });
    }
    private function isVariableJustCreated(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt, string $docVariableName) : bool
    {
        if (!$stmt instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression) {
            return \false;
        }
        if (!$stmt->expr instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        $assign = $stmt->expr;
        // the variable is on the left side = just created
        return $this->isVariableName($assign->var, $docVariableName);
    }
    private function refactorFreshlyCreatedNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $stmt->setAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::COMMENTS, null);
        $type = $phpDocInfo->getVarType();
        $assertFuncCall = $this->createFuncCallBasedOnType($type, $variable);
        if ($assertFuncCall === null) {
            return null;
        }
        $phpDocInfo->removeByType(\_PhpScoperb75b35f52b74\PHPStan\PhpDocParser\Ast\PhpDoc\VarTagValueNode::class);
        $this->addNodeBeforeNode($assertFuncCall, $stmt);
        return $stmt;
    }
    private function refactorAlreadyCreatedNode(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt $stmt, \_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo $phpDocInfo, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $varTagValue = $phpDocInfo->getVarTagValueNode();
        if ($varTagValue === null) {
            throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
        }
        $phpStanType = $this->staticTypeMapper->mapPHPStanPhpDocTypeNodeToPHPStanType($varTagValue->type, $variable);
        $assertFuncCall = $this->createFuncCallBasedOnType($phpStanType, $variable);
        if ($assertFuncCall === null) {
            return null;
        }
        $this->addNodeAfterNode($assertFuncCall, $stmt);
        return $stmt;
    }
    private function createFuncCallBasedOnType(\_PhpScoperb75b35f52b74\PHPStan\Type\Type $type, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable $variable) : ?\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\FuncCall
    {
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType) {
            $instanceOf = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Instanceof_($variable, new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($type->getClassName()));
            return $this->createFuncCall(self::ASSERT, [$instanceOf]);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\IntegerType) {
            $isInt = $this->createFuncCall('is_int', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isInt]);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\FloatType) {
            $funcCall = $this->createFuncCall('is_float', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$funcCall]);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\StringType) {
            $isString = $this->createFuncCall('is_string', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isString]);
        }
        if ($type instanceof \_PhpScoperb75b35f52b74\PHPStan\Type\BooleanType) {
            $isInt = $this->createFuncCall('is_bool', [$variable]);
            return $this->createFuncCall(self::ASSERT, [$isInt]);
        }
        return null;
    }
}
