<?php

declare (strict_types=1);
namespace Rector\TypeDeclaration\AlreadyAssignDetector;

use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\NodeTraverser;
use Rector\Core\ValueObject\MethodName;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\TypeDeclaration\Matcher\PropertyAssignMatcher;
use RectorPrefix20210313\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser;
final class ConstructorAssignDetector
{
    /**
     * @var PropertyAssignMatcher
     */
    private $propertyAssignMatcher;
    /**
     * @var SimpleCallableNodeTraverser
     */
    private $simpleCallableNodeTraverser;
    public function __construct(\Rector\TypeDeclaration\Matcher\PropertyAssignMatcher $propertyAssignMatcher, \RectorPrefix20210313\Symplify\Astral\NodeTraverser\SimpleCallableNodeTraverser $simpleCallableNodeTraverser)
    {
        $this->propertyAssignMatcher = $propertyAssignMatcher;
        $this->simpleCallableNodeTraverser = $simpleCallableNodeTraverser;
    }
    public function isPropertyAssigned(\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $isAssignedInConstructor = \false;
        $this->simpleCallableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\PhpParser\Node $node) use($propertyName, &$isAssignedInConstructor) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if (!$expr instanceof \PhpParser\Node\Expr) {
                return null;
            }
            // is in constructor?
            $methodName = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName !== \Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                return null;
            }
            /** @var Assign $assign */
            $assign = $node;
            $isFirstLevelStatement = $assign->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT);
            // cannot be nested
            if ($isFirstLevelStatement !== \true) {
                return null;
            }
            $isAssignedInConstructor = \true;
            return \PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        });
        return $isAssignedInConstructor;
    }
    private function matchAssignExprToPropertyName(\PhpParser\Node $node, string $propertyName) : ?\PhpParser\Node\Expr
    {
        if (!$node instanceof \PhpParser\Node\Expr\Assign) {
            return null;
        }
        return $this->propertyAssignMatcher->matchPropertyAssignExpr($node, $propertyName);
    }
}
