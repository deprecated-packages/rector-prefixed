<?php

declare (strict_types=1);
namespace Rector\NodeNameResolver;

use RectorPrefix20210309\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\ClassLike;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Type\ObjectType;
use Rector\CodingStyle\Naming\ClassNaming;
use Rector\Core\Contract\Rector\RectorInterface;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use Rector\Core\Util\StaticInstanceOf;
use Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use Rector\NodeNameResolver\Regex\RegexPatternDetector;
use Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use Rector\NodeTypeResolver\Node\AttributeKey;
use RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo;
final class NodeNameResolver
{
    /**
     * @var string
     */
    private const FILE = 'file';
    /**
     * @var NodeNameResolverInterface[]
     */
    private $nodeNameResolvers = [];
    /**
     * @var RegexPatternDetector
     */
    private $regexPatternDetector;
    /**
     * @var CurrentFileInfoProvider
     */
    private $currentFileInfoProvider;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @var ReflectionProvider
     */
    private $reflectionProvider;
    /**
     * @param NodeNameResolverInterface[] $nodeNameResolvers
     */
    public function __construct(\Rector\NodeNameResolver\Regex\RegexPatternDetector $regexPatternDetector, \Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider, \Rector\CodingStyle\Naming\ClassNaming $classNaming, \PHPStan\Reflection\ReflectionProvider $reflectionProvider, array $nodeNameResolvers = [])
    {
        $this->regexPatternDetector = $regexPatternDetector;
        $this->nodeNameResolvers = $nodeNameResolvers;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
        $this->betterStandardPrinter = $betterStandardPrinter;
        $this->classNaming = $classNaming;
        $this->reflectionProvider = $reflectionProvider;
    }
    /**
     * @param string[] $names
     */
    public function isNames(\PhpParser\Node $node, array $names) : bool
    {
        foreach ($names as $name) {
            if ($this->isName($node, $name)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @param Node|Node[] $node
     */
    public function isName($node, string $name) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            $message = \sprintf('Name called on "%s" is not possible. Use $this->getName($node->name) instead', \get_class($node));
            throw new \Rector\Core\Exception\ShouldNotHappenException($message);
        }
        $nodes = \is_array($node) ? $node : [$node];
        foreach ($nodes as $node) {
            if ($this->isSingleName($node, $name)) {
                return \true;
            }
        }
        return \false;
    }
    public function getName(\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall || $node instanceof \PhpParser\Node\Expr\StaticCall) {
            if ($this->isCallOrIdentifier($node->name)) {
                return null;
            }
            $this->reportInvalidNodeForName($node);
        }
        foreach ($this->nodeNameResolvers as $nodeNameResolver) {
            if (!\is_a($node, $nodeNameResolver->getNode(), \true)) {
                continue;
            }
            return $nodeNameResolver->resolve($node);
        }
        // more complex
        if (!\property_exists($node, 'name')) {
            return null;
        }
        // unable to resolve
        if ($node->name instanceof \PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
    public function areNamesEqual(\PhpParser\Node $firstNode, \PhpParser\Node $secondNode) : bool
    {
        $secondResolvedName = $this->getName($secondNode);
        if ($secondResolvedName === null) {
            return \false;
        }
        return $this->isName($firstNode, $secondResolvedName);
    }
    /**
     * @param Name[]|Node[] $nodes
     * @return string[]
     */
    public function getNames(array $nodes) : array
    {
        $names = [];
        foreach ($nodes as $node) {
            $name = $this->getName($node);
            if (!\is_string($name)) {
                throw new \Rector\Core\Exception\ShouldNotHappenException();
            }
            $names[] = $name;
        }
        return $names;
    }
    /**
     * @param Node[] $nodes
     */
    public function haveName(array $nodes, string $name) : bool
    {
        foreach ($nodes as $node) {
            if (!$this->isName($node, $name)) {
                continue;
            }
            return \true;
        }
        return \false;
    }
    public function isLocalPropertyFetchNamed(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if ($node->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isName($node->var, 'this')) {
            return \false;
        }
        if ($node->name instanceof \PhpParser\Node\Expr) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    public function isLocalStaticPropertyFetchNamed(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    /**
     * @param string[] $names
     */
    public function isFuncCallNames(\PhpParser\Node $node, array $names) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isNames($node, $names);
    }
    /**
     * Ends with ucname
     * Starts with adjective, e.g. (Post $firstPost, Post $secondPost)
     */
    public function endsWith(string $currentName, string $expectedName) : bool
    {
        $suffixNamePattern = '#\\w+' . \ucfirst($expectedName) . '#';
        return (bool) \RectorPrefix20210309\Nette\Utils\Strings::match($currentName, $suffixNamePattern);
    }
    public function isLocalMethodCallNamed(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if ($node->var instanceof \PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->var instanceof \PhpParser\Node\Expr\MethodCall) {
            return \false;
        }
        if (!$this->isName($node->var, 'this')) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    /**
     * @param string[] $names
     */
    public function isLocalMethodCallsNamed(\PhpParser\Node $node, array $names) : bool
    {
        foreach ($names as $name) {
            if ($this->isLocalMethodCallNamed($node, $name)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @deprecated Helper function causes to lose the type on the outside. Better avoid it
     */
    public function isFuncCallName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isName($node, $name);
    }
    /**
     * @deprecated Helper function causes to lose the type on the outside. Better avoid it
     */
    public function isStaticCallNamed(\PhpParser\Node $node, string $className, string $methodName) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
            return \false;
        }
        if ($node->class instanceof \PhpParser\Node\Expr\New_) {
            if (!$this->isName($node->class->class, $className)) {
                return \false;
            }
        } elseif (!$this->isName($node->class, $className)) {
            return \false;
        }
        return $this->isName($node->name, $methodName);
    }
    /**
     * @deprecated Helper function causes to lose the type on the outside. Better avoid it
     * @param string[] $methodNames
     */
    public function isStaticCallsNamed(\PhpParser\Node $node, string $className, array $methodNames) : bool
    {
        foreach ($methodNames as $methodName) {
            if ($this->isStaticCallNamed($node, $className, $methodName)) {
                return \true;
            }
        }
        return \false;
    }
    /**
     * @deprecated Helper function causes to lose the type on the outside. Better avoid it
     */
    public function isVariableName(\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \PhpParser\Node\Expr\Variable) {
            return \false;
        }
        return $this->isName($node, $name);
    }
    /**
     * @param ObjectType[] $desiredObjectTypes
     */
    public function isInClassNames(\PhpParser\Node $node, array $desiredObjectTypes) : bool
    {
        $classNode = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if ($classNode === null) {
            return \false;
        }
        foreach ($desiredObjectTypes as $desiredObjectType) {
            if ($this->isInClassNamed($classNode, $desiredObjectType)) {
                return \true;
            }
        }
        return \false;
    }
    public function isInClassNamed(\PhpParser\Node $node, \PHPStan\Type\ObjectType $objectType) : bool
    {
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return \false;
        }
        if (!$this->reflectionProvider->hasClass($className)) {
            return \false;
        }
        $classReflection = $this->reflectionProvider->getClass($className);
        if ($classReflection->getName() === $objectType->getClassName()) {
            return \true;
        }
        return $classReflection->isSubclassOf($objectType->getClassName());
    }
    /**
     * @param string|Name|Identifier|ClassLike $name
     */
    public function getShortName($name) : string
    {
        return $this->classNaming->getShortName($name);
    }
    /**
     * @param array<string, string> $renameMap
     */
    public function matchNameFromMap(\PhpParser\Node $node, array $renameMap) : ?string
    {
        $name = $this->getName($node);
        return $renameMap[$name] ?? null;
    }
    private function isCallOrIdentifier(\PhpParser\Node $node) : bool
    {
        return \Rector\Core\Util\StaticInstanceOf::isOneOf($node, [\PhpParser\Node\Expr\MethodCall::class, \PhpParser\Node\Expr\StaticCall::class, \PhpParser\Node\Identifier::class]);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function reportInvalidNodeForName(\PhpParser\Node $node) : void
    {
        $message = \sprintf('Pick more specific node than "%s", e.g. "$node->name"', \get_class($node));
        $fileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if ($fileInfo instanceof \RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo) {
            $message .= \PHP_EOL . \PHP_EOL;
            $message .= \sprintf('Caused in "%s" file on line %d on code "%s"', $fileInfo->getRelativeFilePathFromCwd(), $node->getStartLine(), $this->betterStandardPrinter->print($node));
        }
        $backtrace = \debug_backtrace();
        $rectorBacktrace = $this->matchRectorBacktraceCall($backtrace);
        if ($rectorBacktrace) {
            // issues to find the file in prefixed
            if (\file_exists($rectorBacktrace[self::FILE])) {
                $fileInfo = new \RectorPrefix20210309\Symplify\SmartFileSystem\SmartFileInfo($rectorBacktrace[self::FILE]);
                $fileAndLine = $fileInfo->getRelativeFilePathFromCwd() . ':' . $rectorBacktrace['line'];
            } else {
                $fileAndLine = $rectorBacktrace[self::FILE] . ':' . $rectorBacktrace['line'];
            }
            $message .= \PHP_EOL . \PHP_EOL;
            $message .= \sprintf('Look at "%s"', $fileAndLine);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException($message);
    }
    /**
     * @param mixed[] $backtrace
     * @return mixed[]|null
     */
    private function matchRectorBacktraceCall(array $backtrace) : ?array
    {
        foreach ($backtrace as $singleBacktrace) {
            if (!isset($singleBacktrace['object'])) {
                continue;
            }
            // match a Rector class
            if (!\is_a($singleBacktrace['object'], \Rector\Core\Contract\Rector\RectorInterface::class)) {
                continue;
            }
            return $singleBacktrace;
        }
        return $backtrace[1] ?? null;
    }
    private function isSingleName(\PhpParser\Node $node, string $name) : bool
    {
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            // method call cannot have a name, only the variable or method name
            return \false;
        }
        $resolvedName = $this->getName($node);
        if ($resolvedName === null) {
            return \false;
        }
        if ($name === '') {
            return \false;
        }
        // is probably regex pattern
        if ($this->regexPatternDetector->isRegexPattern($name)) {
            return (bool) \RectorPrefix20210309\Nette\Utils\Strings::match($resolvedName, $name);
        }
        // is probably fnmatch
        if (\RectorPrefix20210309\Nette\Utils\Strings::contains($name, '*')) {
            return \fnmatch($name, $resolvedName, \FNM_NOESCAPE);
        }
        // special case
        if ($name === 'Object') {
            return $name === $resolvedName;
        }
        return \strtolower($resolvedName) === \strtolower($name);
    }
}
