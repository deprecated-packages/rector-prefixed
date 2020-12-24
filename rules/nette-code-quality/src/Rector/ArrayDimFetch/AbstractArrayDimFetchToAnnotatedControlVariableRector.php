<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Assign;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Variable;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\Naming\NetteControlNaming;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAdding\FunctionLikeFirstLevelStatementResolver;
use _PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 */
abstract class AbstractArrayDimFetchToAnnotatedControlVariableRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ControlDimFetchAnalyzer
     */
    protected $controlDimFetchAnalyzer;
    /**
     * @var NetteControlNaming
     */
    protected $netteControlNaming;
    /**
     * @var VarAnnotationManipulator
     */
    protected $varAnnotationManipulator;
    /**
     * @var string[]
     */
    private $alreadyInitializedAssignsClassMethodObjectHashes = [];
    /**
     * @var FunctionLikeFirstLevelStatementResolver
     */
    private $functionLikeFirstLevelStatementResolver;
    /**
     * @required
     */
    public function autowireAbstractArrayDimFetchToAnnotatedControlVariableRector(\_PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \_PhpScopere8e811afab72\Rector\NetteCodeQuality\NodeAdding\FunctionLikeFirstLevelStatementResolver $functionLikeFirstLevelStatementResolver) : void
    {
        $this->controlDimFetchAnalyzer = $controlDimFetchAnalyzer;
        $this->netteControlNaming = $netteControlNaming;
        $this->varAnnotationManipulator = $varAnnotationManipulator;
        $this->functionLikeFirstLevelStatementResolver = $functionLikeFirstLevelStatementResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    protected function addAssignExpressionForFirstCase(string $variableName, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType $controlObjectType) : void
    {
        if ($this->shouldSkipForAlreadyAddedInCurrentClassMethod($arrayDimFetch, $variableName)) {
            return;
        }
        $assignExpression = $this->createAnnotatedAssignExpression($variableName, $arrayDimFetch, $controlObjectType);
        $currentStatement = $this->functionLikeFirstLevelStatementResolver->resolveFirstLevelStatement($arrayDimFetch);
        $this->addNodeBeforeNode($assignExpression, $currentStatement);
    }
    protected function isBeingAssignedOrInitialized(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parent = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if ($parent->var === $arrayDimFetch) {
            return \true;
        }
        return $parent->expr === $arrayDimFetch;
    }
    private function shouldSkipForAlreadyAddedInCurrentClassMethod(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $variableName) : bool
    {
        /** @var ClassMethod|null $classMethod */
        $classMethod = $arrayDimFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if ($classMethod === null) {
            return \false;
        }
        $classMethodObjectHash = \spl_object_hash($classMethod) . $variableName;
        if (\in_array($classMethodObjectHash, $this->alreadyInitializedAssignsClassMethodObjectHashes, \true)) {
            return \true;
        }
        $this->alreadyInitializedAssignsClassMethodObjectHashes[] = $classMethodObjectHash;
        return \false;
    }
    private function createAnnotatedAssignExpression(string $variableName, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScopere8e811afab72\PHPStan\Type\ObjectType $controlObjectType) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $assignExpression = $this->createAssignExpression($variableName, $arrayDimFetch);
        $this->varAnnotationManipulator->decorateNodeWithInlineVarType($assignExpression, $controlObjectType, $variableName);
        return $assignExpression;
    }
    private function createAssignExpression(string $variableName, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Variable($variableName);
        $assignedArrayDimFetch = clone $arrayDimFetch;
        $assign = new \_PhpScopere8e811afab72\PhpParser\Node\Expr\Assign($variable, $assignedArrayDimFetch);
        return new \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Expression($assign);
    }
}
