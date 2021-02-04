<?php

declare (strict_types=1);
namespace Rector\PhpSpecToPHPUnit\Naming;

use RectorPrefix20210204\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Namespace_;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Util\StaticRectorStrings;
use Rector\NodeNameResolver\NodeNameResolver;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210204\Symplify\PackageBuilder\Strings\StringFormatConverter;
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
    public function __construct(\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \RectorPrefix20210204\Symplify\PackageBuilder\Strings\StringFormatConverter $stringFormatConverter, \Rector\CodingStyle\Naming\ClassNaming $classNaming)
    {
        $this->stringFormatConverter = $stringFormatConverter;
        $this->nodeNameResolver = $nodeNameResolver;
        $this->classNaming = $classNaming;
    }
    public function renameMethod(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        if ($classMethod->isPrivate()) {
            return;
        }
        $classMethodName = $this->nodeNameResolver->getName($classMethod);
        $classMethodName = $this->removeNamePrefixes($classMethodName);
        // from PhpSpec to PHPUnit method naming convention
        $classMethodName = $this->stringFormatConverter->underscoreAndHyphenToCamelCase($classMethodName);
        // add "test", so PHPUnit runs the method
        if (!\RectorPrefix20210204\Nette\Utils\Strings::startsWith($classMethodName, 'test')) {
            $classMethodName = 'test' . \ucfirst($classMethodName);
        }
        $classMethod->name = new \PhpParser\Node\Identifier($classMethodName);
    }
    public function renameExtends(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $class->extends = new \PhpParser\Node\Name\FullyQualified('PHPUnit\\Framework\\TestCase');
    }
    public function renameNamespace(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $namespace = $class->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if (!$namespace instanceof \PhpParser\Node\Stmt\Namespace_) {
            return;
        }
        $namespaceName = $this->nodeNameResolver->getName($namespace);
        if ($namespaceName === null) {
            return;
        }
        $newNamespaceName = \Rector\Core\Util\StaticRectorStrings::removePrefixes($namespaceName, ['spec\\']);
        $namespace->name = new \PhpParser\Node\Name('Tests\\' . $newNamespaceName);
    }
    public function renameClass(\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $classShortName = $this->classNaming->getShortName($class);
        // anonymous class?
        if ($classShortName === '') {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        // 2. change class name
        $newClassName = \Rector\Core\Util\StaticRectorStrings::removeSuffixes($classShortName, [self::SPEC]);
        $newTestClassName = $newClassName . 'Test';
        $class->name = new \PhpParser\Node\Identifier($newTestClassName);
    }
    public function resolveObjectPropertyName(\PhpParser\Node\Stmt\Class_ $class) : string
    {
        // anonymous class?
        if ($class->name === null) {
            throw new \Rector\Core\Exception\ShouldNotHappenException();
        }
        $shortClassName = $this->classNaming->getShortName($class);
        $bareClassName = \Rector\Core\Util\StaticRectorStrings::removeSuffixes($shortClassName, [self::SPEC, 'Test']);
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
