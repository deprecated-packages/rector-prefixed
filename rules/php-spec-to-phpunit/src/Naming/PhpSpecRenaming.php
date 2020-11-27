<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Naming;

use _PhpScoperbd5d0c5f7638\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\PackageBuilder\Strings\StringFormatConverter;
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
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \Symplify\PackageBuilder\Strings\StringFormatConverter $stringFormatConverter)
    {
        $this->stringFormatConverter = $stringFormatConverter;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function renameMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $name = $this->nodeNameResolver->getName($classMethod);
        if ($name === null) {
            return;
        }
        if ($classMethod->isPrivate()) {
            return;
        }
        $name = $this->removeNamePrefixes($name);
        // from PhpSpec to PHPUnit method naming convention
        $name = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($name);
        // add "test", so PHPUnit runs the method
        if (!\_PhpScoperbd5d0c5f7638\Nette\Utils\Strings::startsWith($name, 'test')) {
            $name = 'test' . \ucfirst($name);
        }
        $classMethod->name = new \PhpParser\Node\Identifier($name);
    }
    public function renameExtends(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \PhpParser\Node\Name\FullyQualified('_PhpScoperbd5d0c5f7638\\PHPUnit\\Framework\\TestCase');
    }
    public function renameNamespace(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        /** @var Namespace_ $namespace */
        $namespace = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace->name === null) {
            return;
        }
        $newNamespaceName = \Rector\Core\Util\StaticRectorStrings::removePrefixes($namespace->name->toString(), ['spec\\']);
        $namespace->name = new \PhpParser\Node\Name('Tests\\' . $newNamespaceName);
    }
    public function renameClass(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        // anonymous class?
        if ($class->name === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // 2. change class name
        $newClassName = \Rector\Core\Util\StaticRectorStrings::removeSuffixes($class->name->toString(), [self::SPEC]);
        $newTestClassName = $newClassName . 'Test';
        $class->name = new \PhpParser\Node\Identifier($newTestClassName);
    }
    public function resolveObjectPropertyName(\PhpParser\Node\Stmt\Class_ $class) : string
    {
        // anonymous class?
        if ($class->name === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $bareClassName = \Rector\Core\Util\StaticRectorStrings::removeSuffixes($class->name->toString(), [self::SPEC, 'Test']);
        return \lcfirst($bareClassName);
    }
    public function resolveTestedClass(\PhpParser\Node $node) : string
    {
        /** @var string $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        $newClassName = \Rector\Core\Util\StaticRectorStrings::removePrefixes($className, ['spec\\']);
        return \Rector\Core\Util\StaticRectorStrings::removeSuffixes($newClassName, [self::SPEC]);
    }
    private function removeNamePrefixes(string $name) : string
    {
        $originalName = $name;
        $name = \Rector\Core\Util\StaticRectorStrings::removePrefixes($name, ['it_should_have_', 'it_should_be', 'it_should_', 'it_is_', 'it_', 'is_']);
        return $name ?: $originalName;
    }
}
