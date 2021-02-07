<?php

declare (strict_types=1);
namespace Rector\DeadCode\Rector\Class_;

use RectorPrefix20210207\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Interface_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\PSR4\Collector\RenamedClassesCollector;
use Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionClass;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\DeadCode\Tests\Rector\Class_\RemoveUselessJustForSakeInterfaceRector\RemoveUselessJustForSakeInterfaceRectorTest
 */
final class RemoveUselessJustForSakeInterfaceRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector)
    {
        $this->renamedClassesCollector = $renamedClassesCollector;
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
        if ($node->implements === []) {
            return null;
        }
        foreach ($node->implements as $key => $implement) {
            /** @var string $implementedInterfaceName */
            $implementedInterfaceName = $this->getName($implement);
            if ($this->shouldSkipInterface($implementedInterfaceName)) {
                continue;
            }
            $interfaceImplementers = $this->getInterfaceImplementers($implementedInterfaceName);
            // makes sense
            if (\count($interfaceImplementers) > 1) {
                continue;
            }
            // 1. replace current interface with one more parent or remove it
            $this->removeOrReplaceImplementedInterface($implementedInterfaceName, $node, $key);
            // 2. remove file if not in /vendor
            $classFileLocation = $this->resolveClassFileLocation($implementedInterfaceName);
            $this->removeInterfaceFile($implementedInterfaceName, $classFileLocation);
            // 3. replace interface with explicit current class
            $this->replaceName($node, $implementedInterfaceName);
        }
        return null;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove interface, that are added just for its sake, but nowhere useful', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass implements OnlyHereUsedInterface
{
}

interface OnlyHereUsedInterface
{
}

class SomePresenter
{
    public function __construct(OnlyHereUsedInterface $onlyHereUsed)
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeClass
{
}

class SomePresenter
{
    public function __construct(SomeClass $onlyHereUsed)
    {
    }
}
CODE_SAMPLE
)]);
    }
    private function shouldSkipInterface(string $implementedInterfaceName) : bool
    {
        if (!\interface_exists($implementedInterfaceName)) {
            return \true;
        }
        // is native PHP interface?
        $reflectionClass = new \ReflectionClass($implementedInterfaceName);
        if ($reflectionClass->isInternal()) {
            return \true;
        }
        // is interface in /vendor? probably useful
        $classFileLocation = $this->resolveClassFileLocation($implementedInterfaceName);
        return \RectorPrefix20210207\Nette\Utils\Strings::contains($classFileLocation, 'vendor');
    }
    /**
     * @return class-string[]
     */
    private function getInterfaceImplementers(string $interfaceName) : array
    {
        $declaredClasses = \get_declared_classes();
        return \array_filter($declaredClasses, function (string $className) use($interfaceName) : bool {
            /** @var string[] $classImplements */
            $classImplements = (array) \class_implements($className);
            return \in_array($interfaceName, $classImplements, \true);
        });
    }
    private function removeOrReplaceImplementedInterface(string $implementedInterfaceName, \PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $parentInterface = $this->getParentInterfaceIfFound($implementedInterfaceName);
        if ($parentInterface !== null) {
            $class->implements[$key] = new \PhpParser\Node\Name\FullyQualified($parentInterface);
        } else {
            unset($class->implements[$key]);
        }
    }
    private function resolveClassFileLocation(string $classLikeName) : string
    {
        $reflectionClass = new \ReflectionClass($classLikeName);
        $fileName = $reflectionClass->getFileName();
        if (!$fileName) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        return $fileName;
    }
    private function removeInterfaceFile(string $interfaceName, string $classFileLocation) : void
    {
        if (\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $interface = $this->nodeRepository->findInterface($interfaceName);
            if ($interface instanceof \PhpParser\Node\Stmt\Interface_) {
                $this->removeNode($interface);
            }
        } else {
            $smartFileInfo = new \RectorPrefix20210207\Symplify\SmartFileSystem\SmartFileInfo($classFileLocation);
            $this->removeFile($smartFileInfo);
        }
    }
    private function replaceName(\PhpParser\Node\Stmt\Class_ $class, string $implementedInterfaceName) : void
    {
        $className = $this->getName($class);
        if ($className === null) {
            return;
        }
        $this->renamedClassesCollector->addClassRename($implementedInterfaceName, $className);
    }
    private function getParentInterfaceIfFound(string $implementedInterfaceName) : ?string
    {
        $reflectionClass = new \ReflectionClass($implementedInterfaceName);
        // get first parent interface
        return $reflectionClass->getInterfaceNames()[0] ?? null;
    }
}
