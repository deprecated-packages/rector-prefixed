<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Param;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TraitUse;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
final class NameRenamer
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
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
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TraitUse) {
                $this->renameTraitUse($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_) {
                $this->renameClass($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Param) {
                $this->renameParam($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_) {
                $this->renameNew($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod) {
                $this->renameClassMethod($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_) {
                $this->renameInterface($lastName, $parentNode, $usedName);
            }
            if ($parentNode instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                $this->renameStaticCall($lastName, $parentNode);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameTraitUse(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\TraitUse $traitUse, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        foreach ($traitUse->traits as $key => $traitName) {
            if (!$this->nodeNameResolver->areNamesEqual($traitName, $usedNameNode)) {
                continue;
            }
            $traitUse->traits[$key] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClass(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        if ($class->name !== null && $this->nodeNameResolver->areNamesEqual($class->name, $usedNameNode)) {
            $class->name = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier($lastName);
        }
        if ($class->extends !== null && $this->nodeNameResolver->areNamesEqual($class->extends, $usedNameNode)) {
            $class->extends = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
        }
        foreach ($class->implements as $key => $implementNode) {
            if ($this->nodeNameResolver->areNamesEqual($implementNode, $usedNameNode)) {
                $class->implements[$key] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
            }
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameParam(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Param $param, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        if ($param->type === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($param->type, $usedNameNode)) {
            return;
        }
        $param->type = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameNew(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\New_ $new, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        if ($this->nodeNameResolver->areNamesEqual($new->class, $usedNameNode)) {
            $new->class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
        }
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameClassMethod(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        if ($classMethod->returnType === null) {
            return;
        }
        if (!$this->nodeNameResolver->areNamesEqual($classMethod->returnType, $usedNameNode)) {
            return;
        }
        $classMethod->returnType = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
    }
    /**
     * @param Name|Identifier $usedNameNode
     */
    private function renameInterface(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_ $interface, \_PhpScoper0a2ac50786fa\PhpParser\Node $usedNameNode) : void
    {
        foreach ($interface->extends as $key => $extendInterfaceName) {
            if (!$this->nodeNameResolver->areNamesEqual($extendInterfaceName, $usedNameNode)) {
                continue;
            }
            $interface->extends[$key] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
        }
    }
    private function renameStaticCall(string $lastName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : void
    {
        $staticCall->class = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name($lastName);
    }
}
