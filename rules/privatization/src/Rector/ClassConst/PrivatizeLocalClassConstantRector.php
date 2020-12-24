<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Privatization\Rector\ClassConst;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst;
use _PhpScoper2a4e7ab1ecbc\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\NodeFinder\ParentClassConstantNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\Reflection\ParentConstantReflectionResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Privatization\Tests\Rector\ClassConst\PrivatizeLocalClassConstantRector\PrivatizeLocalClassConstantRectorTest
 */
final class PrivatizeLocalClassConstantRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var string
     */
    private const HAS_NEW_ACCESS_LEVEL = 'has_new_access_level';
    /**
     * @var ParentConstantReflectionResolver
     */
    private $parentConstantReflectionResolver;
    /**
     * @var ParentClassConstantNodeFinder
     */
    private $parentClassConstantNodeFinder;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\NodeFinder\ParentClassConstantNodeFinder $parentClassConstantNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\SOLID\Reflection\ParentConstantReflectionResolver $parentConstantReflectionResolver)
    {
        $this->parentConstantReflectionResolver = $parentConstantReflectionResolver;
        $this->parentClassConstantNodeFinder = $parentClassConstantNodeFinder;
    }
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Finalize every class constant that is used only locally', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ClassWithConstantUsedOnlyHere
{
    const LOCAL_ONLY = true;

    public function isLocalOnly()
    {
        return self::LOCAL_ONLY;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ClassWithConstantUsedOnlyHere
{
    private const LOCAL_ONLY = true;

    public function isLocalOnly()
    {
        return self::LOCAL_ONLY;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst::class];
    }
    /**
     * @param ClassConst $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        /** @var string $class */
        $class = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        // Remember when we have already processed this constant recursively
        $node->setAttribute(self::HAS_NEW_ACCESS_LEVEL, \true);
        $nodeRepositoryFindInterface = $this->nodeRepository->findInterface($class);
        // 0. constants declared in interfaces have to be public
        if ($nodeRepositoryFindInterface !== null) {
            $this->makePublic($node);
            return $node;
        }
        /** @var string $constant */
        $constant = $this->getName($node);
        $parentClassConstantVisibility = $this->findParentClassConstantAndRefactorIfPossible($class, $constant);
        // The parent's constant is public, so this one must become public too
        if ($parentClassConstantVisibility !== null && $parentClassConstantVisibility->isPublic()) {
            $this->makePublic($node);
            return $node;
        }
        $directUseClasses = $this->nodeRepository->findDirectClassConstantFetches($class, $constant);
        $indirectUseClasses = $this->nodeRepository->findIndirectClassConstantFetches($class, $constant);
        $this->changeConstantVisibility($node, $directUseClasses, $indirectUseClasses, $parentClassConstantVisibility, $class);
        return $node;
    }
    private function shouldSkip(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst $classConst) : bool
    {
        $hasNewAccessLevel = $classConst->getAttribute(self::HAS_NEW_ACCESS_LEVEL);
        if ($hasNewAccessLevel) {
            return \true;
        }
        if (!$this->isAtLeastPhpVersion(\_PhpScoper2a4e7ab1ecbc\Rector\Core\ValueObject\PhpVersionFeature::CONSTANT_VISIBILITY)) {
            return \true;
        }
        if (\count((array) $classConst->consts) !== 1) {
            return \true;
        }
        /** @var PhpDocInfo|null $phpDocInfo */
        $phpDocInfo = $classConst->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo !== null && $phpDocInfo->hasByName('api')) {
            return \true;
        }
        /** @var string|null $class */
        $class = $classConst->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        return $class === null;
    }
    private function findParentClassConstantAndRefactorIfPossible(string $class, string $constant) : ?\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility
    {
        $parentClassConst = $this->parentClassConstantNodeFinder->find($class, $constant);
        if ($parentClassConst !== null) {
            // Make sure the parent's constant has been refactored
            $this->refactor($parentClassConst);
            return new \_PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility($parentClassConst->isPublic(), $parentClassConst->isProtected(), $parentClassConst->isPrivate());
            // If the constant isn't declared in the parent, it might be declared in the parent's parent
        }
        $parentClassConstantReflection = $this->parentConstantReflectionResolver->resolve($class, $constant);
        if ($parentClassConstantReflection === null) {
            return null;
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility($parentClassConstantReflection->isPublic(), $parentClassConstantReflection->isProtected(), $parentClassConstantReflection->isPrivate());
    }
    /**
     * @param string[] $directUseClasses
     * @param string[] $indirectUseClasses
     */
    private function changeConstantVisibility(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst $classConst, array $directUseClasses, array $indirectUseClasses, ?\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility $constantVisibility, string $class) : void
    {
        // 1. is actually never used
        if ($directUseClasses === []) {
            if ($indirectUseClasses !== [] && $constantVisibility !== null) {
                $this->makePrivateOrWeaker($classConst, $constantVisibility);
            }
            return;
        }
        // 2. is only local use? → private
        if ($directUseClasses === [$class]) {
            if ($indirectUseClasses === []) {
                $this->makePrivateOrWeaker($classConst, $constantVisibility);
            }
            return;
        }
        // 3. used by children → protected
        if ($this->isUsedByChildrenOnly($directUseClasses, $class)) {
            $this->makeProtected($classConst);
        } else {
            $this->makePublic($classConst);
        }
    }
    private function makePrivateOrWeaker(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassConst $classConst, ?\_PhpScoper2a4e7ab1ecbc\Rector\SOLID\ValueObject\ConstantVisibility $parentConstantVisibility) : void
    {
        if ($parentConstantVisibility !== null && $parentConstantVisibility->isProtected()) {
            $this->makeProtected($classConst);
        } elseif ($parentConstantVisibility !== null && $parentConstantVisibility->isPrivate() && !$parentConstantVisibility->isProtected()) {
            $this->makePrivate($classConst);
        } elseif ($parentConstantVisibility === null) {
            $this->makePrivate($classConst);
        }
    }
    /**
     * @param string[] $useClasses
     */
    private function isUsedByChildrenOnly(array $useClasses, string $class) : bool
    {
        $isChild = \false;
        foreach ($useClasses as $useClass) {
            if (\is_a($useClass, $class, \true)) {
                $isChild = \true;
            } else {
                // not a child, must be public
                return \false;
            }
        }
        return $isChild;
    }
}
