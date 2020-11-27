<?php

declare (strict_types=1);
namespace Rector\Core\Rector\AbstractRector;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator;
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
    public function autowireVisibilityTrait(\Rector\Core\PhpParser\Node\Manipulator\VisibilityManipulator $visibilityManipulator) : void
    {
        $this->visibilityManipulator = $visibilityManipulator;
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function changeNodeVisibility(\PhpParser\Node $node, string $visibility) : void
    {
        $this->visibilityManipulator->changeNodeVisibility($node, $visibility);
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function makeFinal(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeFinal($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function removeVisibility(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->removeOriginalVisibilityFromFlags($node);
    }
    /**
     * @param ClassMethod|Class_ $node
     */
    public function makeAbstract(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeAbstract($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makePublic(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makePublic($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makeProtected(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeProtected($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makePrivate(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makePrivate($node);
    }
    /**
     * @param ClassMethod|Property|ClassConst $node
     */
    public function makeStatic(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeStatic($node);
    }
    /**
     * @param ClassMethod|Property $node
     */
    public function makeNonStatic(\PhpParser\Node $node) : void
    {
        $this->visibilityManipulator->makeNonStatic($node);
    }
}
