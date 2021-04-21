<?php

declare(strict_types=1);

namespace Rector\Privatization\NodeManipulator;

use PhpParser\Node;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Core\Exception\InvalidNodeTypeException;
use Rector\Core\ValueObject\Visibility;
use Webmozart\Assert\Assert;

final class VisibilityManipulator
{
    /**
     * @var array<class-string<Stmt>>
     */
    const ALLOWED_NODE_TYPES = [ClassMethod::class, Property::class, ClassConst::class, Class_::class];

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function makeStatic(Node $node)
    {
        $this->addVisibilityFlag($node, Visibility::STATIC);
    }

    /**
     * @param ClassMethod|Class_ $node
     * @return void
     */
    public function makeAbstract(Node $node)
    {
        $this->addVisibilityFlag($node, Visibility::ABSTRACT);
    }

    /**
     * @param ClassMethod|Property $node
     * @return void
     */
    public function makeNonStatic(Node $node)
    {
        if (! $node->isStatic()) {
            return;
        }

        $node->flags -= Class_::MODIFIER_STATIC;
    }

    /**
     * @param Class_|ClassMethod $node
     * @return void
     */
    public function makeFinal(Node $node)
    {
        $this->addVisibilityFlag($node, Visibility::FINAL);
    }

    /**
     * @param Class_|ClassMethod $node
     * @return void
     */
    public function makeNonFinal(Node $node)
    {
        if (! $node->isFinal()) {
            return;
        }

        $node->flags -= Class_::MODIFIER_FINAL;
    }

    /**
     * This way "abstract", "static", "final" are kept
     *
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function removeVisibility(Node $node)
    {
        $this->ensureIsClassMethodOrProperty($node, __METHOD__);

        // no modifier
        if ($node->flags === 0) {
            return;
        }

        if ($node->isPublic()) {
            $node->flags -= Class_::MODIFIER_PUBLIC;
        }

        if ($node->isProtected()) {
            $node->flags -= Class_::MODIFIER_PROTECTED;
        }

        if ($node->isPrivate()) {
            $node->flags -= Class_::MODIFIER_PRIVATE;
        }
    }

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function changeNodeVisibility(Node $node, int $visibility)
    {
        Assert::oneOf($visibility, [
            Visibility::PUBLIC,
            Visibility::PROTECTED,
            Visibility::PRIVATE,
            Visibility::STATIC,
            Visibility::ABSTRACT,
            Visibility::FINAL,
        ]);

        $this->replaceVisibilityFlag($node, $visibility);
    }

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function makePublic(Node $node)
    {
        $this->replaceVisibilityFlag($node, Visibility::PUBLIC);
    }

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function makeProtected(Node $node)
    {
        $this->replaceVisibilityFlag($node, Visibility::PROTECTED);
    }

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    public function makePrivate(Node $node)
    {
        $this->replaceVisibilityFlag($node, Visibility::PRIVATE);
    }

    /**
     * @return void
     */
    public function removeFinal(Class_ $class)
    {
        $class->flags -= Class_::MODIFIER_FINAL;
    }

    /**
     * @param Class_|ClassMethod|Property|ClassConst $node
     * @return void
     */
    private function addVisibilityFlag(Node $node, int $visibility)
    {
        $this->ensureIsClassMethodOrProperty($node, __METHOD__);
        $node->flags |= $visibility;
    }

    /**
     * @return void
     */
    private function ensureIsClassMethodOrProperty(Node $node, string $location)
    {
        foreach (self::ALLOWED_NODE_TYPES as $allowedNodeType) {
            if (is_a($node, $allowedNodeType, true)) {
                return;
            }
        }

        throw new InvalidNodeTypeException(sprintf(
            '"%s" only accepts "%s" types. "%s" given.',
            $location,
            implode('", "', self::ALLOWED_NODE_TYPES),
            get_class($node)
        ));
    }

    /**
     * @param ClassMethod|Property|ClassConst $node
     * @return void
     */
    private function replaceVisibilityFlag(Node $node, int $visibility)
    {
        $isStatic = $node instanceof ClassMethod && $node->isStatic();
        if ($isStatic) {
            $this->removeVisibility($node);
        }

        if ($visibility !== Visibility::STATIC && $visibility !== Visibility::ABSTRACT && $visibility !== Visibility::FINAL) {
            $this->removeVisibility($node);
        }

        $this->addVisibilityFlag($node, $visibility);

        if ($isStatic) {
            $this->makeStatic($node);
        }
    }
}
