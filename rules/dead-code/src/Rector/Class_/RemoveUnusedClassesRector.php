<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Class_;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use Rector\Caching\Contract\Rector\ZeroCacheRectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\DeadCode\UnusedNodeResolver\UnusedClassResolver;
use Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Rector\PhpAttribute\ValueObject\TagName;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveUnusedClassesRector\RemoveUnusedClassesRectorTest
 */
final class RemoveUnusedClassesRector extends \Rector\Core\Rector\AbstractRector implements \Rector\Caching\Contract\Rector\ZeroCacheRectorInterface
{
    /**
     * @var UnusedClassResolver
     */
    private $unusedClassResolver;
    /**
     * @var DoctrineDocBlockResolver
     */
    private $doctrineDocBlockResolver;
    public function __construct(\Rector\DeadCode\UnusedNodeResolver\UnusedClassResolver $unusedClassResolver, \Rector\Doctrine\PhpDocParser\DoctrineDocBlockResolver $doctrineDocBlockResolver)
    {
        $this->unusedClassResolver = $unusedClassResolver;
        $this->doctrineDocBlockResolver = $doctrineDocBlockResolver;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove unused classes without interface', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
interface SomeInterface
{
}

class SomeClass implements SomeInterface
{
    public function run($items)
    {
        return null;
    }
}

class NowhereUsedClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
interface SomeInterface
{
}

class SomeClass implements SomeInterface
{
    public function run($items)
    {
        return null;
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
        return [\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if ($this->shouldSkip($node)) {
            return null;
        }
        if ($this->unusedClassResolver->isClassUsed($node)) {
            return null;
        }
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $this->removeNode($node);
        } else {
            $smartFileInfo = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::FILE_INFO);
            if (!$smartFileInfo instanceof \RectorPrefix20210122\Symplify\SmartFileSystem\SmartFileInfo) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $this->removeFile($smartFileInfo);
        }
        return null;
    }
    private function shouldSkip(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        if (!$this->unusedClassResolver->isClassWithoutInterfaceAndNotController($class)) {
            return \true;
        }
        if ($this->doctrineDocBlockResolver->isDoctrineEntityClass($class)) {
            return \true;
        }
        // most of factories can be only registered in config and create services there
        // skip them for now; but in the future, detect types they create in public methods and only keep them, if they're used
        if ($this->isName($class, '*Factory')) {
            return \true;
        }
        if ($this->hasMethodWithApiAnnotation($class)) {
            return \true;
        }
        if ($this->hasTagByName($class, \Rector\PhpAttribute\ValueObject\TagName::API)) {
            return \true;
        }
        return $class->isAbstract();
    }
    private function hasMethodWithApiAnnotation(\PhpParser\Node\Stmt\Class_ $class) : bool
    {
        foreach ($class->getMethods() as $classMethod) {
            if (!$this->hasTagByName($classMethod, \Rector\PhpAttribute\ValueObject\TagName::API)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
}
