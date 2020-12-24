<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Legacy\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName;
use _PhpScopere8e811afab72\Rector\Legacy\NodeAnalyzer\SingletonClassMethodAnalyzer;
use _PhpScopere8e811afab72\Rector\Legacy\ValueObject\PropertyAndClassMethodName;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://3v4l.org/lifbH
 * @see https://stackoverflow.com/a/203359/1348344
 * @see http://cleancode.blog/2017/07/20/how-to-avoid-many-instances-in-singleton-pattern/
 * @see \Rector\Legacy\Tests\Rector\Class_\ChangeSingletonToServiceRector\ChangeSingletonToServiceRectorTest
 */
final class ChangeSingletonToServiceRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var SingletonClassMethodAnalyzer
     */
    private $singletonClassMethodAnalyzer;
    public function __construct(\_PhpScopere8e811afab72\Rector\Legacy\NodeAnalyzer\SingletonClassMethodAnalyzer $singletonClassMethodAnalyzer)
    {
        $this->singletonClassMethodAnalyzer = $singletonClassMethodAnalyzer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change singleton class to normal class that can be registered as a service', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
    public function __construct()
    {
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($node->isAnonymous()) {
            return null;
        }
        $propertyAndClassMethodName = $this->matchStaticPropertyFetchAndGetSingletonMethodName($node);
        if ($propertyAndClassMethodName === null) {
            return null;
        }
        return $this->refactorClassStmts($node, $propertyAndClassMethodName);
    }
    private function matchStaticPropertyFetchAndGetSingletonMethodName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : ?\_PhpScopere8e811afab72\Rector\Legacy\ValueObject\PropertyAndClassMethodName
    {
        foreach ($class->getMethods() as $classMethod) {
            if (!$classMethod->isStatic()) {
                continue;
            }
            $staticPropertyFetch = $this->singletonClassMethodAnalyzer->matchStaticPropertyFetch($classMethod);
            if ($staticPropertyFetch === null) {
                return null;
            }
            /** @var string $propertyName */
            $propertyName = $this->getName($staticPropertyFetch);
            /** @var string $classMethodName */
            $classMethodName = $this->getName($classMethod);
            return new \_PhpScopere8e811afab72\Rector\Legacy\ValueObject\PropertyAndClassMethodName($propertyName, $classMethodName);
        }
        return null;
    }
    private function refactorClassStmts(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, \_PhpScopere8e811afab72\Rector\Legacy\ValueObject\PropertyAndClassMethodName $propertyAndClassMethodName) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_
    {
        foreach ($class->getMethods() as $classMethod) {
            if ($this->isName($classMethod, $propertyAndClassMethodName->getClassMethodName())) {
                $this->removeNodeFromStatements($class, $classMethod);
                continue;
            }
            if (!$this->isNames($classMethod, [\_PhpScopere8e811afab72\Rector\Core\ValueObject\MethodName::CONSTRUCT, '__clone', '__wakeup'])) {
                continue;
            }
            if ($classMethod->isPublic()) {
                continue;
            }
            // remove non-public empty
            if ($classMethod->stmts === []) {
                $this->removeNodeFromStatements($class, $classMethod);
            } else {
                $this->makePublic($classMethod);
            }
        }
        $this->removePropertyByName($class, $propertyAndClassMethodName->getPropertyName());
        return $class;
    }
    private function removePropertyByName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class, string $propertyName) : void
    {
        foreach ($class->getProperties() as $property) {
            if (!$this->isName($property, $propertyName)) {
                continue;
            }
            $this->removeNodeFromStatements($class, $property);
        }
    }
}
