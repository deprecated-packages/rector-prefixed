<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Restoration\Rector\Class_;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Rector\PSR4\Collector\RenamedClassesCollector;
use _PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment;
use ReflectionClass;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @sponsor Thanks https://amateri.com for sponsoring this rule - visit them on https://www.startupjobs.cz/startup/scrumworks-s-r-o
 *
 * @see \Rector\Restoration\Tests\Rector\Class_\RemoveUselessJustForSakeInterfaceRector\RemoveUselessJustForSakeInterfaceRectorTest
 */
final class RemoveUselessJustForSakeInterfaceRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private $interfacePattern;
    /**
     * @var RenamedClassesCollector
     */
    private $renamedClassesCollector;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\PSR4\Collector\RenamedClassesCollector $renamedClassesCollector, string $interfacePattern = '#(.*?)#')
    {
        $this->interfacePattern = $interfacePattern;
        $this->renamedClassesCollector = $renamedClassesCollector;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        if ((array) $node->implements === []) {
            return null;
        }
        foreach ($node->implements as $key => $implement) {
            $implementedInterfaceName = $this->getName($implement);
            if (!\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($implementedInterfaceName, $this->interfacePattern)) {
                continue;
            }
            // is interface in /vendor? probably useful
            $classFileLocation = $this->resolveClassFileLocation($implementedInterfaceName);
            if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($classFileLocation, 'vendor')) {
                continue;
            }
            $interfaceImplementers = $this->getInterfaceImplementers($implementedInterfaceName);
            // makes sense
            if (\count($interfaceImplementers) > 1) {
                continue;
            }
            // 1. replace current interface with one more parent or remove it
            $this->removeOrReplaceImlementedInterface($implementedInterfaceName, $node, $key);
            // 2. remove file if not in /vendor
            $this->removeInterfaceFile($implementedInterfaceName, $classFileLocation);
            // 3. replace interface with explicit current class
            $this->replaceName($node, $implementedInterfaceName);
        }
        return null;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove interface, that are added just for its sake, but nowhere useful', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
    private function resolveClassFileLocation(string $implementedInterfaceName) : string
    {
        $reflectionClass = new \ReflectionClass($implementedInterfaceName);
        $fileName = $reflectionClass->getFileName();
        if (!$fileName) {
            throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
        }
        return $fileName;
    }
    /**
     * @return class-string[]
     */
    private function getInterfaceImplementers(string $interfaceName) : array
    {
        return \array_filter(\get_declared_classes(), function (string $className) use($interfaceName) : bool {
            /** @var string[] $classImplements */
            $classImplements = (array) \class_implements($className);
            return \in_array($interfaceName, $classImplements, \true);
        });
    }
    private function removeOrReplaceImlementedInterface(string $implementedInterfaceName, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, int $key) : void
    {
        $parentInterface = $this->getParentInterfaceIfFound($implementedInterfaceName);
        if ($parentInterface !== null) {
            $class->implements[$key] = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified($parentInterface);
        } else {
            unset($class->implements[$key]);
        }
    }
    private function removeInterfaceFile(string $interfaceName, string $classFileLocation) : void
    {
        if (\_PhpScoper0a2ac50786fa\Rector\Testing\PHPUnit\StaticPHPUnitEnvironment::isPHPUnitRun()) {
            $interface = $this->nodeRepository->findInterface($interfaceName);
            if ($interface instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Interface_) {
                $this->removeNode($interface);
            }
        } else {
            $smartFileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($classFileLocation);
            $this->removeFile($smartFileInfo);
        }
    }
    private function replaceName(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Class_ $class, string $implementedInterfaceName) : void
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
