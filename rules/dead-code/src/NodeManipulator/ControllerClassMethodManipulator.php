<?php

declare (strict_types=1);
namespace Rector\DeadCode\NodeManipulator;

use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode;
use PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode;
use Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
final class ControllerClassMethodManipulator
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function isControllerClassMethodWithBehaviorAnnotation(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isControllerClassMethod($classMethod)) {
            return \false;
        }
        $phpDocInfo = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if (!$phpDocInfo instanceof \Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo) {
            return \false;
        }
        foreach ($phpDocInfo->getPhpDocNode()->children as $phpDocChildNode) {
            if (!$phpDocChildNode instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\PhpDocTagNode) {
                continue;
            }
            if ($phpDocChildNode->value instanceof \PHPStan\PhpDocParser\Ast\PhpDoc\GenericTagValueNode) {
                return \true;
            }
        }
        return \false;
    }
    private function isControllerClassMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$classMethod->isPublic()) {
            return \false;
        }
        $classLike = $classMethod->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return \false;
        }
        return $this->hasParentClassController($classLike);
    }
    private function hasParentClassController(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->extends === null) {
            return \false;
        }
        return $this->nodeNameResolver->isName($class->extends, '#(Controller|Presenter)$#');
    }
}
