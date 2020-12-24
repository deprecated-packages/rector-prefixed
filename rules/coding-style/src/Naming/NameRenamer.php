<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\CodingStyle\Naming;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Identifier;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name;
use _PhpScoperb75b35f52b74\PhpParser\Node\Param;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse;
use _PhpScoperb75b35f52b74\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver;
final class NameRenamer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoperb75b35f52b74\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @param NameAndParent[] $usedNameNodes
     */
    public function renameNameNode(array $usedNameNodes, string $lastName) : void
    {
        foreach ($usedNameNodes as $nameAndParent) {
            $parentNode = $nameAndParent->getParentNode();
            $usedName = $nameAndParent->getNameNode();
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse) {
                $this->renameTraitUse($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
                $this->renameClass($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Param) {
                $this->renameParam($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_) {
                $this->renameNew($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
                $this->renameClassMethod($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_) {
                $this->renameInterface($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall) {
                $this->renameStaticCall($lastName, $parentNode);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameTraitUse(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\TraitUse $traitUse, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        foreach ($traitUse->traits as $key => $traitName) {
            if (!$this->nodeNameResolver->areNamesEqual($traitName, $usedNameNode)) {
                continue;
            }
            $traitUse->traits[$key] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClass(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_ $class, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        if ($class->name !== null && $this->nodeNameResolver->areNamesEqual($class->name, $usedNameNode)) {
            $class->name = new \_PhpScoperb75b35f52b74\PhpParser\Node\Identifier($lastName);
        }
        if ($class->extends !== null && $this->nodeNameResolver->areNamesEqual($class->extends, $usedNameNode)) {
            $class->extends = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
        }
        foreach ($class->implements as $key => $implementNode) {
            if ($this->nodeNameResolver->areNamesEqual($implementNode, $usedNameNode)) {
                $class->implements[$key] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameParam(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Param $param, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        if ($param->type === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($param->type, $usedNameNode)) {
            return;
        }
        $param->type = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameNew(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_ $new, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        if ($this->nodeNameResolver->areNamesEqual($new->class, $usedNameNode)) {
            $new->class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClassMethod(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        if ($classMethod->returnType === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($classMethod->returnType, $usedNameNode)) {
            return;
        }
        $classMethod->returnType = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameInterface(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Interface_ $interface, \_PhpScoperb75b35f52b74\PhpParser\Node $usedNameNode) : void
    {
        foreach ($interface->extends as $key => $extendInterfaceName) {
            if (!$this->nodeNameResolver->areNamesEqual($extendInterfaceName, $usedNameNode)) {
                continue;
            }
            $interface->extends[$key] = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
        }
    }
    private function renameStaticCall(string $lastName, \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $staticCall->class = new \_PhpScoperb75b35f52b74\PhpParser\Node\Name($lastName);
    }
}
