<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\PhpSpecToPHPUnit\Naming;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\PackageBuilder\Strings\StringFormatConverter;
final class PhpSpecRenaming
{
    /**
     * @var string
     */
    private const SPEC = 'Spec';
    /**
     * @var StringFormatConverter
     */
    private $stringFormatConverter;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScopere8e811afab72\Symplify\PackageBuilder\Strings\StringFormatConverter $stringFormatConverter, \_PhpScopere8e811afab72\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->stringFormatConverter = $stringFormatConverter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function renameMethod(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->isPrivate()) {
            return;
        }
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $classMethodName = $this->removeNamePrefixes($classMethodName);
        // from PhpSpec to PHPUnit method naming convention
        $classMethodName = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($classMethodName);
        // add "test", so PHPUnit runs the method
        if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::startsWith($classMethodName, 'test')) {
            $classMethodName = 'test' . \ucfirst($classMethodName);
        }
        $classMethod->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($classMethodName);
    }
    public function renameExtends(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified('_PhpScopere8e811afab72\\PHPUnit\\Framework\\TestCase');
    }
    public function renameNamespace(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        /** @var Namespace_|null $namespace */
        $namespace = $class->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            return;
        }
        $namespaceName = $this->nodeNameResolver->getName($namespace);
        if ($namespaceName === null) {
            return;
        }
        $newNamespaceName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removePrefixes($namespaceName, ['spec\\']);
        $namespace->name = new \_PhpScopere8e811afab72\PhpParser\Node\Name('Tests\\' . $newNamespaceName);
    }
    public function renameClass(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $classShortName = $this->classNaming->getShortName($class);
        // anonymous class?
        if ($classShortName === '') {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        // 2. change class name
        $newClassName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removeSuffixes($classShortName, [self::SPEC]);
        $newTestClassName = $newClassName . 'Test';
        $class->name = new \_PhpScopere8e811afab72\PhpParser\Node\Identifier($newTestClassName);
    }
    public function resolveObjectPropertyName(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_ $class) : string
    {
        // anonymous class?
        if ($class->name === null) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $shortClassName = $this->classNaming->getShortName($class);
        $bareClassName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removeSuffixes($shortClassName, [self::SPEC, 'Test']);
        return \lcfirst($bareClassName);
    }
    public function resolveTestedClass(\_PhpScopere8e811afab72\PhpParser\Node $node) : string
    {
        /** @var string $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $newClassName = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removePrefixes($className, ['spec\\']);
        return \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removeSuffixes($newClassName, [self::SPEC]);
    }
    private function removeNamePrefixes(string $name) : string
    {
        $originalName = $name;
        $name = \_PhpScopere8e811afab72\Rector\Core\Util\StaticRectorStrings::removePrefixes($name, ['it_should_have_', 'it_should_be', 'it_should_', 'it_is_', 'it_', 'is_']);
        return $name ?: $originalName;
    }
}
