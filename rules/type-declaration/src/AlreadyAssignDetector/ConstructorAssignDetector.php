<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\Assign;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike;
use _PhpScoperb75b35f52b74\PhpParser\NodeTraverser;
use _PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
final class ConstructorAssignDetector extends \_PhpScoperb75b35f52b74\Rector\TypeDeclaration\AlreadyAssignDetector\AbstractAssignDetector
{
    public function isPropertyAssigned(\_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassLike $classLike, string $propertyName) : bool
    {
        $isAssignedInConstructor = \false;
        $this->callableNodeTraverser->traverseNodesWithCallable($classLike->stmts, function (\_PhpScoperb75b35f52b74\PhpParser\Node $node) use($propertyName, &$isAssignedInConstructor) : ?int {
            $expr = $this->matchAssignExprToPropertyName($node, $propertyName);
            if ($expr === null) {
                return null;
            }
            // is in constructor?
            $methodName = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NAME);
            if ($methodName !== \_PhpScoperb75b35f52b74\Rector\Core\ValueObject\MethodName::CONSTRUCT) {
                return null;
            }
            /** @var Assign $assign */
            $assign = $node;
            $isFirstLevelStatement = $assign->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::IS_FIRST_LEVEL_STATEMENT);
            // cannot be nested
            if ($isFirstLevelStatement !== \true) {
                return null;
            }
            $isAssignedInConstructor = \true;
            return \_PhpScoperb75b35f52b74\PhpParser\NodeTraverser::DONT_TRAVERSE_CURRENT_AND_CHILDREN;
        });
        return $isAssignedInConstructor;
    }
}
