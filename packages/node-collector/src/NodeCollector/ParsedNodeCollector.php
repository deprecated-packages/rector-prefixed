<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\NodeCollector\NodeCollector;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Array_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\New_;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
/**
 * All parsed nodes grouped type
 * @template TNodeType of Node
 * @see https://phpstan.org/blog/generics-in-php-using-phpdocs
 */
final class ParsedNodeCollector
{
    /**
     * @var class-string[]
     */
    private const COLLECTABLE_NODE_TYPES = [
        \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class,
        // simply collected
        \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall::class,
        \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class,
        // for array callable - [$this, 'someCall']
        \_PhpScopere8e811afab72\PhpParser\Node\Expr\Array_::class,
        // for unused classes
        \_PhpScopere8e811afab72\PhpParser\Node\Param::class,
    ];
    /**
     * @var Class_[]
     */
    private $classes = [];
    /**
     * @var ClassConst[][]
     */
    private $constantsByType = [];
    /**
     * @var Interface_[]
     */
    private $interfaces = [];
    /**
     * @var Trait_[]
     */
    private $traits = [];
    /**
     * @var StaticCall[]
     */
    private $staticCalls = [];
    /**
     * @var New_[]
     */
    private $news = [];
    /**
     * @var Param[]
     */
    private $params = [];
    /**
     * @var ClassConstFetch[]
     */
    private $classConstFetches = [];
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
    }
    /**
     * @return Interface_[]
     */
    public function getInterfaces() : array
    {
        return $this->interfaces;
    }
    /**
     * @return Class_[]
     */
    public function getClasses() : array
    {
        return $this->classes;
    }
    public function findClass(string $name) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        return $this->classes[$name] ?? null;
    }
    public function findInterface(string $name) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_
    {
        return $this->interfaces[$name] ?? null;
    }
    public function findTrait(string $name) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_
    {
        return $this->traits[$name] ?? null;
    }
    /**
     * Guessing the nearest neighboor.
     * Used e.g. for "XController"
     */
    public function findByShortName(string $shortName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        foreach ($this->classes as $className => $classNode) {
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($className, '\\' . $shortName)) {
                return $classNode;
            }
        }
        return null;
    }
    public function findClassConstant(string $className, string $constantName) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst
    {
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($constantName, '\\')) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException(\sprintf('Switched arguments in "%s"', __METHOD__));
        }
        return $this->constantsByType[$className][$constantName] ?? null;
    }
    public function isCollectableNode(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        foreach (self::COLLECTABLE_NODE_TYPES as $collectableNodeType) {
            if (\is_a($node, $collectableNodeType, \true)) {
                return \true;
            }
        }
        return \false;
    }
    public function collect(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            $this->addClass($node);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_ || $node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_) {
            $this->collectInterfaceOrTrait($node);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst) {
            $this->addClassConstant($node);
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            $this->staticCalls[] = $node;
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\New_) {
            $this->news[] = $node;
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Param) {
            $this->params[] = $node;
            return;
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch) {
            $this->classConstFetches[] = $node;
        }
    }
    /**
     * @return New_[]
     */
    public function findNewsByClass(string $className) : array
    {
        $newsByClass = [];
        foreach ($this->news as $new) {
            if (!$this->nodeNameResolver->isName($new->class, $className)) {
                continue;
            }
            $newsByClass[] = $new;
        }
        return $newsByClass;
    }
    public function findClassConstByClassConstFetch(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $classConstFetch) : ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst
    {
        $className = $this->nodeNameResolver->getName($classConstFetch->class);
        if ($className === null) {
            return null;
        }
        $class = $this->resolveClassConstant($classConstFetch, $className);
        if ($class === null) {
            return null;
        }
        /** @var string $constantName */
        $constantName = $this->nodeNameResolver->getName($classConstFetch->name);
        return $this->findClassConstant($class, $constantName);
    }
    /**
     * @return ClassConstFetch[]
     */
    public function getClassConstFetches() : array
    {
        return $this->classConstFetches;
    }
    /**
     * @return Param[]
     */
    public function getParams() : array
    {
        return $this->params;
    }
    /**
     * @return New_[]
     */
    public function getNews() : array
    {
        return $this->news;
    }
    /**
     * @return StaticCall[]
     */
    public function getStaticCalls() : array
    {
        return $this->staticCalls;
    }
    private function addClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        if ($this->isClassAnonymous($class)) {
            return;
        }
        $className = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $this->classes[$className] = $class;
    }
    /**
     * @param Interface_|Trait_ $classLike
     */
    private function collectInterfaceOrTrait(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassLike $classLike) : void
    {
        $name = $this->nodeNameResolver->getName($classLike);
        if ($name === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        if ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Interface_) {
            $this->interfaces[$name] = $classLike;
        } elseif ($classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Trait_) {
            $this->traits[$name] = $classLike;
        }
    }
    private function addClassConstant(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassConst $classConst) : void
    {
        $className = $classConst->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            // anonymous class constant
            return;
        }
        $constantName = $this->nodeNameResolver->getName($classConst);
        $this->constantsByType[$className][$constantName] = $classConst;
    }
    private function resolveClassConstant(\_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch $classConstFetch, string $className) : ?string
    {
        if ($className === 'self') {
            return $classConstFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        }
        if ($className === 'parent') {
            return $classConstFetch->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_CLASS_NAME);
        }
        return $className;
    }
    private function isClassAnonymous(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if ($class->isAnonymous()) {
            return \true;
        }
        $className = $this->nodeNameResolver->getName($class);
        if ($className === null) {
            return \true;
        }
        // PHPStan polution
        return \_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($className, 'AnonymousClass');
    }
}
