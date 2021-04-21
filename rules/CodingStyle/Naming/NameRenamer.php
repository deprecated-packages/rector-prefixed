<?php

declare(strict_types=1);

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

    public function __construct(NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @param NameAndParent[] $usedNameNodes
     * @return void
     */
    public function renameNameNode(array $usedNameNodes, string $lastName)
    {
        foreach ($usedNameNodes as $usedNameNode) {
            $parentNode = $usedNameNode->getParentNode();
            $usedName = $usedNameNode->getNameNode();

            if ($parentNode instanceof TraitUse) {
                $this->renameTraitUse($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof Class_) {
                $this->renameClass($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof Param) {
                $this->renameParam($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof New_) {
                $this->renameNew($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof ClassMethod) {
                $this->renameClassMethod($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof Interface_) {
                $this->renameInterface($lastName, $parentNode, $usedName);
            }

            if ($parentNode instanceof StaticCall) {
                $this->renameStaticCall($lastName, $parentNode);
            }
        }
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameTraitUse(string $lastName, TraitUse $traitUse, Node $usedNameNode)
    {
        foreach ($traitUse->traits as $key => $traitName) {
            if (! $this->nodeNameResolver->areNamesEqual($traitName, $usedNameNode)) {
                continue;
            }

            $traitUse->traits[$key] = new Name($lastName);
        }
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameClass(string $lastName, Class_ $class, Node $usedNameNode)
    {
        if ($class->name !== null && $this->nodeNameResolver->areNamesEqual($class->name, $usedNameNode)) {
            $class->name = new Identifier($lastName);
        }

        if ($class->extends !== null && $this->nodeNameResolver->areNamesEqual($class->extends, $usedNameNode)) {
            $class->extends = new Name($lastName);
        }

        foreach ($class->implements as $key => $implementNode) {
            if ($this->nodeNameResolver->areNamesEqual($implementNode, $usedNameNode)) {
                $class->implements[$key] = new Name($lastName);
            }
        }
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameParam(string $lastName, Param $param, Node $usedNameNode)
    {
        if ($param->type === null) {
            return;
        }
        if (! $this->nodeNameResolver->areNamesEqual($param->type, $usedNameNode)) {
            return;
        }
        $param->type = new Name($lastName);
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameNew(string $lastName, New_ $new, Node $usedNameNode)
    {
        if ($this->nodeNameResolver->areNamesEqual($new->class, $usedNameNode)) {
            $new->class = new Name($lastName);
        }
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameClassMethod(string $lastName, ClassMethod $classMethod, Node $usedNameNode)
    {
        if ($classMethod->returnType === null) {
            return;
        }

        if (! $this->nodeNameResolver->areNamesEqual($classMethod->returnType, $usedNameNode)) {
            return;
        }

        $classMethod->returnType = new Name($lastName);
    }

    /**
     * @param Name|Identifier $usedNameNode
     * @return void
     */
    private function renameInterface(string $lastName, Interface_ $interface, Node $usedNameNode)
    {
        foreach ($interface->extends as $key => $extendInterfaceName) {
            if (! $this->nodeNameResolver->areNamesEqual($extendInterfaceName, $usedNameNode)) {
                continue;
            }

            $interface->extends[$key] = new Name($lastName);
        }
    }

    /**
     * @return void
     */
    private function renameStaticCall(string $lastName, StaticCall $staticCall)
    {
        $staticCall->class = new Name($lastName);
    }
}
