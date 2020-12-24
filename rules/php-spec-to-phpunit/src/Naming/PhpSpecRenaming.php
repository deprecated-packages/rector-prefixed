<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\PhpSpecToPHPUnit\Naming;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Strings\StringFormatConverter;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Symplify\PackageBuilder\Strings\StringFormatConverter $stringFormatConverter, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->stringFormatConverter = $stringFormatConverter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function renameMethod(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->isPrivate()) {
            return;
        }
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $classMethodName = $this->removeNamePrefixes($classMethodName);
        // from PhpSpec to PHPUnit method naming convention
        $classMethodName = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($classMethodName);
        // add "test", so PHPUnit runs the method
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::startsWith($classMethodName, 'test')) {
            $classMethodName = 'test' . \ucfirst($classMethodName);
        }
        $classMethod->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($classMethodName);
    }
    public function renameExtends(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name\FullyQualified('_PhpScoper2a4e7ab1ecbc\\PHPUnit\\Framework\\TestCase');
    }
    public function renameNamespace(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        /** @var Namespace_|null $namespace */
        $namespace = $class->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            return;
        }
        $namespaceName = $this->nodeNameResolver->getName($namespace);
        if ($namespaceName === null) {
            return;
        }
        $newNamespaceName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removePrefixes($namespaceName, ['spec\\']);
        $namespace->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('Tests\\' . $newNamespaceName);
    }
    public function renameClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $classShortName = $this->classNaming->getShortName($class);
        // anonymous class?
        if ($classShortName === '') {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        // 2. change class name
        $newClassName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removeSuffixes($classShortName, [self::SPEC]);
        $newTestClassName = $newClassName . 'Test';
        $class->name = new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Identifier($newTestClassName);
    }
    public function resolveObjectPropertyName(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Class_ $class) : string
    {
        // anonymous class?
        if ($class->name === null) {
            throw new \_PhpScoper2a4e7ab1ecbc\Rector\Core\Exception\ShouldNotHappenException();
        }
        $shortClassName = $this->classNaming->getShortName($class);
        $bareClassName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removeSuffixes($shortClassName, [self::SPEC, 'Test']);
        return \lcfirst($bareClassName);
    }
    public function resolveTestedClass(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : string
    {
        /** @var string $className */
        $className = $node->getAttribute(\_PhpScoper2a4e7ab1ecbc\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $newClassName = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removePrefixes($className, ['spec\\']);
        return \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removeSuffixes($newClassName, [self::SPEC]);
    }
    private function removeNamePrefixes(string $name) : string
    {
        $originalName = $name;
        $name = \_PhpScoper2a4e7ab1ecbc\Rector\Core\Util\StaticRectorStrings::removePrefixes($name, ['it_should_have_', 'it_should_be', 'it_should_', 'it_is_', 'it_', 'is_']);
        return $name ?: $originalName;
    }
}
