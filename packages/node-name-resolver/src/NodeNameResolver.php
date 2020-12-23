<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\NodeNameResolver;

use _PhpScoper0a2ac50786fa\Nette\Utils\Strings;
use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name;
use _PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\RectorInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Contract\NodeNameResolverInterface;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Regex\RegexPatternDetector;
use _PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
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
     * @var BetterStandardPrinter
     */
    private $betterStandardPrinter;
    /**
     * @param NodeNameResolverInterface[] $nodeNameResolvers
     */
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\Regex\RegexPatternDetector $regexPatternDetector, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Printer\BetterStandardPrinter $betterStandardPrinter, \_PhpScoper0a2ac50786fa\Rector\NodeTypeResolver\FileSystem\CurrentFileInfoProvider $currentFileInfoProvider, array $nodeNameResolvers = [])
    {
        $this->regexPatternDetector = $regexPatternDetector;
        $this->nodeNameResolvers = $nodeNameResolvers;
        $this->currentFileInfoProvider = $currentFileInfoProvider;
        $this->betterStandardPrinter = $betterStandardPrinter;
    }
    /**
     * @param string[] $names
     */
    public function isNames(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, array $names) : bool
    {
        foreach ($names as $name) {
            if ($this->isName($node, $name)) {
                return \true;
            }
        }
        return \false;
    }
    public function isName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $name) : bool
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall) {
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
            return (bool) \_PhpScoper0a2ac50786fa\Nette\Utils\Strings::match($resolvedName, $name);
        }
        // is probably fnmatch
        if (\_PhpScoper0a2ac50786fa\Nette\Utils\Strings::contains($name, '*')) {
            return \fnmatch($name, $resolvedName, \FNM_NOESCAPE);
        }
        // special case
        if ($name === 'Object') {
            return $name === $resolvedName;
        }
        return \strtolower($resolvedName) === \strtolower($name);
    }
    public function getName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?string
    {
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall || $node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
            if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall || $node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall || $node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
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
        if ($node->name instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr) {
            return null;
        }
        return (string) $node->name;
    }
    public function areNamesEqual(\_PhpScoper0a2ac50786fa\PhpParser\Node $firstNode, \_PhpScoper0a2ac50786fa\PhpParser\Node $secondNode) : bool
    {
        return $this->getName($firstNode) === $this->getName($secondNode);
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
                throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException();
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
    public function isLocalPropertyFetchNamed(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\PropertyFetch) {
            return \false;
        }
        if (!$this->isName($node->var, 'this')) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    public function isLocalStaticPropertyFetchNamed(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, string $name) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticPropertyFetch) {
            return \false;
        }
        return $this->isName($node->name, $name);
    }
    /**
     * @param string[] $names
     */
    public function isFuncCallNames(\_PhpScoper0a2ac50786fa\PhpParser\Node $node, array $names) : bool
    {
        if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
            return \false;
        }
        return $this->isNames($node, $names);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function reportInvalidNodeForName(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : void
    {
        $message = \sprintf('Pick more specific node than "%s", e.g. "$node->name"', \get_class($node));
        $fileInfo = $this->currentFileInfoProvider->getSmartFileInfo();
        if ($fileInfo instanceof \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo) {
            $message .= \PHP_EOL . \PHP_EOL;
            $message .= \sprintf('Caused in "%s" file on line %d on code "%s"', $fileInfo->getRelativeFilePathFromCwd(), $node->getStartLine(), $this->betterStandardPrinter->print($node));
        }
        $backtrace = \debug_backtrace();
        $rectorBacktrace = $this->matchRectorBacktraceCall($backtrace);
        if ($rectorBacktrace) {
            // issues to find the file in prefixed
            if (\file_exists($rectorBacktrace[self::FILE])) {
                $fileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($rectorBacktrace[self::FILE]);
                $fileAndLine = $fileInfo->getRelativeFilePathFromCwd() . ':' . $rectorBacktrace['line'];
            } else {
                $fileAndLine = $rectorBacktrace[self::FILE] . ':' . $rectorBacktrace['line'];
            }
            $message .= \PHP_EOL . \PHP_EOL;
            $message .= \sprintf('Look at "%s"', $fileAndLine);
        }
        throw new \_PhpScoper0a2ac50786fa\Rector\Core\Exception\ShouldNotHappenException($message);
    }
    /**
     * @param mixed[] $backtrace
     * @return mixed[]|null
     */
    private function matchRectorBacktraceCall(array $backtrace) : ?array
    {
        foreach ($backtrace as $singleTrace) {
            if (!isset($singleTrace['object'])) {
                continue;
            }
            // match a Rector class
            if (!\is_a($singleTrace['object'], \_PhpScoper0a2ac50786fa\Rector\Core\Contract\Rector\RectorInterface::class)) {
                continue;
            }
            return $singleTrace;
        }
        return $backtrace[1] ?? null;
    }
}
