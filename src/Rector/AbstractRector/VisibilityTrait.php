<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Property;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator;
/**
 * This could be part of @see AbstractRector, but decopuling to trait
 * makes clear what code has 1 purpose.
 */
trait VisibilityTrait
{
    /**
     * @var VisibilityManipulator
     */
    private $visibilityManipulator;
    /**
     * @required
     */
    public function autowireVisibilityTrait(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator $visibilityManipulator) : void
    {
        $this->visibilityManipulator = $visibilityManipulator;
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function changeNodeVisibility(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, string $visibility) : void
    {
        $this->visibilityManipulator->changeNodeVisibility($node, $visibility);
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function makeFinal(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeFinal($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function removeVisibility(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->removeOriginalVisibilityFromFlags($node);
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function makeAbstract(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeAbstract($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makePublic(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makePublic($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makeProtected(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeProtected($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makePrivate(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makePrivate($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makeStatic(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeStatic($node);
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function makeNonStatic(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeNonStatic($node);
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function makeNonFinal(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeNonFinal($node);
    }
}
