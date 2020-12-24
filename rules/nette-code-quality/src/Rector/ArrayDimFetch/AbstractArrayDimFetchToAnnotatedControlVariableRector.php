<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Rector\ArrayDimFetch;

use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression;
use _PhpScoperb75b35f52b74\PHPStan\Type\ObjectType;
use _PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator;
use _PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Naming\NetteControlNaming;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAdding\FunctionLikeFirstLevelStatementResolver;
use _PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 */
abstract class AbstractArrayDimFetchToAnnotatedControlVariableRector extends \_PhpScoperb75b35f52b74\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractArrayDimFetchToAnnotatedControlVariableRector(\_PhpScoperb75b35f52b74\Rector\BetterPhpDocParser\PhpDocManipulator\VarAnnotationManipulator $varAnnotationManipulator, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAnalyzer\ControlDimFetchAnalyzer $controlDimFetchAnalyzer, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\Naming\NetteControlNaming $netteControlNaming, \_PhpScoperb75b35f52b74\Rector\NetteCodeQuality\NodeAdding\FunctionLikeFirstLevelStatementResolver $functionLikeFirstLevelStatementResolver) : void
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
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch::class];
    }
    protected function addAssignExpressionForFirstCase(string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $controlObjectType) : void
    {
        if ($this->shouldSkipForAlreadyAddedInCurrentClassMethod($arrayDimFetch, $variableName)) {
            return;
        }
        $assignExpression = $this->createAnnotatedAssignExpression($variableName, $arrayDimFetch, $controlObjectType);
        $currentStatement = $this->functionLikeFirstLevelStatementResolver->resolveFirstLevelStatement($arrayDimFetch);
        $this->addNodeBeforeNode($assignExpression, $currentStatement);
    }
    protected function isBeingAssignedOrInitialized(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : bool
    {
        $parent = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if (!$parent instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign) {
            return \false;
        }
        if ($parent->var === $arrayDimFetch) {
            return \true;
        }
        return $parent->expr === $arrayDimFetch;
    }
    private function shouldSkipForAlreadyAddedInCurrentClassMethod(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, string $variableName) : bool
    {
        /** @var ClassMethod|null $classMethod */
        $classMethod = $arrayDimFetch->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
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
    private function createAnnotatedAssignExpression(string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch, \_PhpScoperb75b35f52b74\PHPStan\Type\ObjectType $controlObjectType) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $assignExpression = $this->createAssignExpression($variableName, $arrayDimFetch);
        $this->varAnnotationManipulator->decorateNodeWithInlineVarType($assignExpression, $controlObjectType, $variableName);
        return $assignExpression;
    }
    private function createAssignExpression(string $variableName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\ArrayDimFetch $arrayDimFetch) : \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression
    {
        $variable = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Variable($variableName);
        $assignedArrayDimFetch = clone $arrayDimFetch;
        $assign = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign($variable, $assignedArrayDimFetch);
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Expression($assign);
    }
}
