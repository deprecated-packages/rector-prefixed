<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Naming;

use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\Node\Stmt\TraitUse;
use Rector\CodingStyle\ValueObject\NameAndParent;
use Rector\NodeNameResolver\NodeNameResolver;
final class NameRenamer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param NameAndParent[] $usedNameNodes
     */
    public function renameNameNode(array $usedNameNodes, string $lastName) : void
    {
        foreach ($usedNameNodes as $usedNameNode) {
            $parentNode = $usedNameNode->getParentNode();
            $usedName = $usedNameNode->getNameNode();
            if ($parentNode instanceof \PhpParser\Node\Stmt\TraitUse) {
                $this->renameTraitUse($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Stmt\Class_) {
                $this->renameClass($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Param) {
                $this->renameParam($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Expr\New_) {
                $this->renameNew($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Stmt\ClassMethod) {
                $this->renameClassMethod($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Stmt\Interface_) {
                $this->renameInterface($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \PhpParser\Node\Expr\StaticCall) {
                $this->renameStaticCall($lastName, $parentNode);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameTraitUse(string $lastName, \PhpParser\Node\Stmt\TraitUse $traitUse, \PhpParser\Node $usedNameNode) : void
    {
        foreach ($traitUse->traits as $key => $traitName) {
            if (!$this->nodeNameResolver->areNamesEqual($traitName, $usedNameNode)) {
                continue;
            }
            $traitUse->traits[$key] = new \PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClass(string $lastName, \PhpParser\Node\Stmt\Class_ $class, \PhpParser\Node $usedNameNode) : void
    {
        if ($class->name !== null && $this->nodeNameResolver->areNamesEqual($class->name, $usedNameNode)) {
            $class->name = new \PhpParser\Node\Identifier($lastName);
        }
        if ($class->extends !== null && $this->nodeNameResolver->areNamesEqual($class->extends, $usedNameNode)) {
            $class->extends = new \PhpParser\Node\Name($lastName);
        }
        foreach ($class->implements as $key => $implementNode) {
            if ($this->nodeNameResolver->areNamesEqual($implementNode, $usedNameNode)) {
                $class->implements[$key] = new \PhpParser\Node\Name($lastName);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameParam(string $lastName, \PhpParser\Node\Param $param, \PhpParser\Node $usedNameNode) : void
    {
        if ($param->type === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($param->type, $usedNameNode)) {
            return;
        }
        $param->type = new \PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameNew(string $lastName, \PhpParser\Node\Expr\New_ $new, \PhpParser\Node $usedNameNode) : void
    {
        if ($this->nodeNameResolver->areNamesEqual($new->class, $usedNameNode)) {
            $new->class = new \PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClassMethod(string $lastName, \PhpParser\Node\Stmt\ClassMethod $classMethod, \PhpParser\Node $usedNameNode) : void
    {
        if ($classMethod->returnType === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($classMethod->returnType, $usedNameNode)) {
            return;
        }
        $classMethod->returnType = new \PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameInterface(string $lastName, \PhpParser\Node\Stmt\Interface_ $interface, \PhpParser\Node $usedNameNode) : void
    {
        foreach ($interface->extends as $key => $extendInterfaceName) {
            if (!$this->nodeNameResolver->areNamesEqual($extendInterfaceName, $usedNameNode)) {
                continue;
            }
            $interface->extends[$key] = new \PhpParser\Node\Name($lastName);
        }
    }
    private function renameStaticCall(string $lastName, \PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $staticCall->class = new \PhpParser\Node\Name($lastName);
    }
}
