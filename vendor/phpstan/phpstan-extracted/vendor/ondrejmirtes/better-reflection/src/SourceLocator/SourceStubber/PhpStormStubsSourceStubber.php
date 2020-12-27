<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber;

use Error;
use _HumbugBox221ad6f1b81f\JetBrains\PHPStormStub\PhpStormStubsMap;
use ParseError;
use PhpParser\BuilderFactory;
use PhpParser\BuilderHelpers;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser;
use PhpParser\PrettyPrinter\Standard;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\Exception\CouldNotFindPhpStormStubs;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\ConstantNodeChecker;
use Traversable;
use function array_change_key_case;
use function array_key_exists;
use function assert;
use function constant;
use function count;
use function defined;
use function explode;
use function file_get_contents;
use function in_array;
use function is_dir;
use function is_string;
use function preg_match;
use function sprintf;
use function str_replace;
use function strpos;
use function strtolower;
use function strtoupper;
use const PHP_VERSION_ID;
/**
 * @internal
 */
final class PhpStormStubsSourceStubber implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\SourceStubber
{
    private const BUILDER_OPTIONS = ['shortArraySyntax' => \true];
    private const SEARCH_DIRECTORIES = [__DIR__ . '/../../../../../jetbrains/phpstorm-stubs', __DIR__ . '/../../../vendor/jetbrains/phpstorm-stubs'];
    /** @var Parser */
    private $phpParser;
    /** @var int */
    private $phpVersionId;
    /** @var BuilderFactory */
    private $builderFactory;
    /** @var Standard */
    private $prettyPrinter;
    /** @var NodeTraverser */
    private $nodeTraverser;
    /** @var string|null */
    private $stubsDirectory;
    /** @var NodeVisitorAbstract */
    private $cachingVisitor;
    /** @var array<string, Node\Stmt\ClassLike|null> */
    private $classNodes = [];
    /** @var array<string, Node\Stmt\Function_|null> */
    private $functionNodes = [];
    /**
     * `null` means "failed lookup" for constant that is not case insensitive
     *
     * @var array<string, Node\Stmt\Const_|Node\Expr\FuncCall|null>
     */
    private $constantNodes = [];
    /** @var array<lowercase-string, string> */
    private $classMap;
    /** @var array<lowercase-string, string> */
    private $functionMap;
    /** @var array<lowercase-string, string> */
    private $constantMap;
    public function __construct(\PhpParser\Parser $phpParser, ?int $phpVersionId = null)
    {
        $this->phpParser = $phpParser;
        $this->phpVersionId = $phpVersionId ?? \PHP_VERSION_ID;
        $this->builderFactory = new \PhpParser\BuilderFactory();
        $this->prettyPrinter = new \PhpParser\PrettyPrinter\Standard(self::BUILDER_OPTIONS);
        $this->cachingVisitor = $this->createCachingVisitor();
        $this->nodeTraverser = new \PhpParser\NodeTraverser();
        $this->nodeTraverser->addVisitor(new \PhpParser\NodeVisitor\NameResolver());
        $this->nodeTraverser->addVisitor($this->cachingVisitor);
        $this->classMap = \array_change_key_case(\_HumbugBox221ad6f1b81f\JetBrains\PHPStormStub\PhpStormStubsMap::CLASSES);
        $this->functionMap = \array_change_key_case(\_HumbugBox221ad6f1b81f\JetBrains\PHPStormStub\PhpStormStubsMap::FUNCTIONS);
        $this->constantMap = \_HumbugBox221ad6f1b81f\JetBrains\PHPStormStub\PhpStormStubsMap::CONSTANTS;
    }
    public function hasClass(string $className) : bool
    {
        $lowercaseClassName = \strtolower($className);
        return \array_key_exists($lowercaseClassName, $this->classMap);
    }
    public function isPresentClass(string $className) : ?bool
    {
        $lowercaseClassName = \strtolower($className);
        if (!\array_key_exists($lowercaseClassName, $this->classMap)) {
            return null;
        }
        $filePath = $this->classMap[$lowercaseClassName];
        $classNode = $this->findClassNode($filePath, $lowercaseClassName);
        return $classNode !== null;
    }
    public function isPresentFunction(string $functionName) : ?bool
    {
        $lowercaseFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowercaseFunctionName, $this->functionMap)) {
            return null;
        }
        $filePath = $this->functionMap[$lowercaseFunctionName];
        $functionNode = $this->findFunctionNode($filePath, $lowercaseFunctionName);
        return $functionNode !== null;
    }
    public function generateClassStub(string $className) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowercaseClassName = \strtolower($className);
        if (!\array_key_exists($lowercaseClassName, $this->classMap)) {
            return null;
        }
        $filePath = $this->classMap[$lowercaseClassName];
        $classNode = $this->findClassNode($filePath, $lowercaseClassName);
        if ($classNode === null) {
            return null;
        }
        if ($classNode instanceof \PhpParser\Node\Stmt\Class_) {
            if ($classNode->name instanceof \PhpParser\Node\Identifier && $classNode->name->toString() === \ParseError::class && $this->phpVersionId < 70300) {
                $classNode->extends = new \PhpParser\Node\Name\FullyQualified(\Error::class);
            } elseif ($classNode->extends !== null) {
                $filteredExtends = $this->filterNames([$classNode->extends]);
                if ($filteredExtends === []) {
                    $classNode->extends = null;
                }
            }
            $classNode->implements = $this->filterNames($classNode->implements);
        } elseif ($classNode instanceof \PhpParser\Node\Stmt\Interface_) {
            $classNode->extends = $this->filterNames($classNode->extends);
        }
        $stub = $this->createStub($classNode);
        if ($className === \Traversable::class) {
            // See https://github.com/JetBrains/phpstorm-stubs/commit/0778a26992c47d7dbee4d0b0bfb7fad4344371b1#diff-575bacb45377d474336c71cbf53c1729
            $stub = \str_replace(' extends \\iterable', '', $stub);
        }
        if ($className === 'PDOStatement' && $this->phpVersionId < 80000) {
            $stub = \str_replace('implements \\IteratorAggregate', 'implements \\Traversable', $stub);
        }
        if ($className === 'DatePeriod' && $this->phpVersionId < 80000) {
            $stub = \str_replace('implements \\IteratorAggregate', 'implements \\Traversable', $stub);
        }
        if ($className === 'SplFixedArray' && $this->phpVersionId < 80000) {
            $stub = \str_replace(', \\IteratorAggregate', '', $stub);
        }
        if ($className === 'SimpleXMLElement' && $this->phpVersionId < 80000) {
            $stub = \str_replace(', \\RecursiveIterator', '', $stub);
        }
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData($stub, $this->getExtensionFromFilePath($filePath), $this->getAbsoluteFilePath($filePath));
    }
    private function findClassNode(string $filePath, string $lowercaseName) : ?\PhpParser\Node\Stmt\ClassLike
    {
        if (!\array_key_exists($lowercaseName, $this->classNodes)) {
            $this->parseFile($filePath);
            if (!\array_key_exists($lowercaseName, $this->classNodes)) {
                $this->classNodes[$lowercaseName] = null;
                return null;
            }
        }
        return $this->classNodes[$lowercaseName];
    }
    /**
     * @param Node\Name[] $names
     *
     * @return Node\Name[]
     */
    private function filterNames(array $names) : array
    {
        $filtered = [];
        foreach ($names as $name) {
            $lowercaseName = $name->toLowerString();
            if (!\array_key_exists($lowercaseName, $this->classMap)) {
                continue;
            }
            $filePath = $this->classMap[$lowercaseName];
            $classNode = $this->findClassNode($filePath, $lowercaseName);
            if ($classNode === null) {
                continue;
            }
            $filtered[] = $name;
        }
        return $filtered;
    }
    public function generateFunctionStub(string $functionName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowercaseFunctionName = \strtolower($functionName);
        if (!\array_key_exists($lowercaseFunctionName, $this->functionMap)) {
            return null;
        }
        $filePath = $this->functionMap[$lowercaseFunctionName];
        $functionNode = $this->findFunctionNode($filePath, $lowercaseFunctionName);
        if ($functionNode === null) {
            return null;
        }
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData($this->createStub($functionNode), $this->getExtensionFromFilePath($filePath));
    }
    private function findFunctionNode(string $filePath, string $lowercaseFunctionName) : ?\PhpParser\Node\Stmt\Function_
    {
        if (!\array_key_exists($lowercaseFunctionName, $this->functionNodes)) {
            $this->parseFile($filePath);
            if (!\array_key_exists($lowercaseFunctionName, $this->functionNodes)) {
                $this->functionNodes[$lowercaseFunctionName] = null;
                return null;
            }
        }
        return $this->functionNodes[$lowercaseFunctionName];
    }
    public function generateConstantStub(string $constantName) : ?\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData
    {
        $lowercaseConstantName = $constantName;
        if (\in_array($constantName, ['TRUE', 'FALSE', 'NULL'], \true)) {
            $lowercaseConstantName = \strtolower($constantName);
        }
        if (!\array_key_exists($lowercaseConstantName, $this->constantMap)) {
            return null;
        }
        if (\array_key_exists($lowercaseConstantName, $this->constantNodes) && $this->constantNodes[$lowercaseConstantName] === null) {
            return null;
        }
        $filePath = $this->constantMap[$lowercaseConstantName];
        $constantNode = $this->constantNodes[$constantName] ?? $this->constantNodes[$lowercaseConstantName] ?? null;
        if ($constantNode === null) {
            $this->parseFile($filePath);
            $constantNode = $this->constantNodes[$constantName] ?? $this->constantNodes[$lowercaseConstantName] ?? null;
            if ($constantNode === null) {
                // Still `null` - the constant is not case-insensitive. Save `null` so we don't parse the file again for the same $constantName
                $this->constantNodes[$lowercaseConstantName] = null;
                return null;
            }
        }
        return new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\StubData($this->createStub($constantNode), $this->getExtensionFromFilePath($filePath));
    }
    private function parseFile(string $filePath) : void
    {
        $absoluteFilePath = $this->getAbsoluteFilePath($filePath);
        \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\FileChecker::assertReadableFile($absoluteFilePath);
        $isCore = $this->isCoreExtension($this->getExtensionFromFilePath($filePath));
        $ast = $this->phpParser->parse(\file_get_contents($absoluteFilePath));
        /** @psalm-suppress UndefinedMethod */
        $this->cachingVisitor->clearNodes();
        $this->nodeTraverser->traverse($ast);
        /**
         * @psalm-suppress UndefinedMethod
         */
        foreach ($this->cachingVisitor->getClassNodes() as $className => $classNode) {
            \assert(\is_string($className));
            \assert($classNode instanceof \PhpParser\Node\Stmt\ClassLike);
            if ($isCore && $this->hasLaterSinceVersion($classNode)) {
                continue;
            }
            $classNode->stmts = $this->filterStmts($classNode->stmts);
            $this->classNodes[\strtolower($className)] = $classNode;
        }
        /**
         * @psalm-suppress UndefinedMethod
         */
        foreach ($this->cachingVisitor->getFunctionNodes() as $functionName => $functionNode) {
            \assert(\is_string($functionName));
            \assert($functionNode instanceof \PhpParser\Node\Stmt\Function_);
            if (\strpos($functionName, '-')) {
                [$functionName] = \explode('--', $functionName);
            }
            if ($functionName !== 'array_push' && $isCore && $this->hasLaterSinceVersion($functionNode)) {
                continue;
            }
            $this->functionNodes[\strtolower($functionName)] = $functionNode;
        }
        /**
         * @psalm-suppress UndefinedMethod
         */
        foreach ($this->cachingVisitor->getConstantNodes() as $constantName => $constantNode) {
            \assert(\is_string($constantName));
            \assert($constantNode instanceof \PhpParser\Node\Stmt\Const_ || $constantNode instanceof \PhpParser\Node\Expr\FuncCall);
            if ($isCore && $this->hasLaterSinceVersion($constantNode)) {
                continue;
            }
            $this->constantNodes[$constantName] = $constantNode;
        }
    }
    /**
     * @param Node\Stmt[] $stmts
     *
     * @return Node\Stmt[]
     */
    private function filterStmts(array $stmts) : array
    {
        $newStmts = [];
        foreach ($stmts as $stmt) {
            if ($this->hasLaterSinceVersion($stmt)) {
                continue;
            }
            $newStmts[] = $stmt;
        }
        return $newStmts;
    }
    private function hasLaterSinceVersion(\PhpParser\Node $node) : bool
    {
        $docComment = $node->getDocComment();
        if ($docComment === null) {
            return \false;
        }
        $sinceResult = \preg_match('#@since\\s+(\\d+\\.\\d+(?:\\.\\d+)?)#', $docComment->getText(), $sinceMatches);
        if ($sinceResult) {
            $since = $sinceMatches[1];
            $sinceParts = \explode('.', $since);
            $sinceId = $sinceParts[0] * 10000 + $sinceParts[1] * 100 + ($sinceParts[2] ?? 0);
            if ($sinceId > $this->phpVersionId) {
                return \true;
            }
        }
        $removedResult = \preg_match('#@removed\\s+(\\d+\\.\\d+(?:\\.\\d+)?)#', $docComment->getText(), $removedMatches);
        if ($removedResult) {
            $removed = $removedMatches[1];
            $removedParts = \explode('.', $removed);
            $removedId = $removedParts[0] * 10000 + $removedParts[1] * 100 + ($removedParts[2] ?? 0);
            return $removedId <= $this->phpVersionId;
        }
        return \false;
    }
    private function isCoreExtension(string $extension) : bool
    {
        return \in_array($extension, ['apache', 'bcmath', 'bz2', 'calendar', 'Core', 'ctype', 'curl', 'date', 'dba', 'dom', 'enchant', 'exif', 'FFI', 'fileinfo', 'filter', 'fpm', 'ftp', 'gd', 'gettext', 'gmp', 'hash', 'iconv', 'imap', 'interbase', 'intl', 'json', 'ldap', 'libxml', 'mbstring', 'mcrypt', 'mssql', 'mysql', 'mysqli', 'oci8', 'odbc', 'openssl', 'pcntl', 'pcre', 'PDO', 'pdo_ibm', 'pgsql', 'Phar', 'phpdbg', 'posix', 'pspell', 'readline', 'recode', 'Reflection', 'regex', 'session', 'shmop', 'SimpleXML', 'snmp', 'soap', 'sockets', 'sodium', 'SPL', 'sqlite3', 'standard', 'sybase', 'sysvmsg', 'sysvsem', 'sysvshm', 'tidy', 'tokenizer', 'wddx', 'xml', 'xmlreader', 'xmlrpc', 'xmlwriter', 'xsl', 'Zend OPcache', 'zip', 'zlib'], \true);
    }
    /**
     * @param Node\Stmt\ClassLike|Node\Stmt\Function_|Node\Stmt\Const_|Node\Expr\FuncCall $node
     */
    private function createStub(\PhpParser\Node $node) : string
    {
        $nodeWithNamespaceName = $node instanceof \PhpParser\Node\Stmt\Const_ ? $node->consts[0] : $node;
        if (isset($nodeWithNamespaceName->namespacedName)) {
            $namespaceBuilder = $this->builderFactory->namespace($nodeWithNamespaceName->namespacedName->slice(0, -1));
            $namespaceBuilder->addStmt($node);
            $node = $namespaceBuilder->getNode();
        }
        $printed = $this->prettyPrinter->prettyPrint([$node]);
        $printed = \str_replace('PS_UNRESERVE_PREFIX_', '', $printed);
        return "<?php\n\n" . $printed . ($node instanceof \PhpParser\Node\Expr\FuncCall ? ';' : '') . "\n";
    }
    private function createCachingVisitor() : \PhpParser\NodeVisitorAbstract
    {
        return new class extends \PhpParser\NodeVisitorAbstract
        {
            /** @var array<string, Node\Stmt\ClassLike> */
            private $classNodes = [];
            /** @var array<string, Node\Stmt\Function_> */
            private $functionNodes = [];
            /** @var array<string, Node\Stmt\Const_|Node\Expr\FuncCall> */
            private $constantNodes = [];
            public function enterNode(\PhpParser\Node $node) : ?int
            {
                if ($node instanceof \PhpParser\Node\Stmt\ClassLike) {
                    $nodeName = $node->namespacedName->toString();
                    $this->classNodes[$nodeName] = $node;
                    return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                if ($node instanceof \PhpParser\Node\Stmt\Function_) {
                    /** @psalm-suppress UndefinedPropertyFetch */
                    $nodeName = (string) $node->namespacedName->toString();
                    $i = 1;
                    $variantNodeName = $nodeName;
                    while (\array_key_exists($variantNodeName, $this->functionNodes)) {
                        $variantNodeName = \sprintf('%s--%d', $nodeName, $i);
                        $i++;
                        continue;
                    }
                    $this->functionNodes[$variantNodeName] = $node;
                    return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                if ($node instanceof \PhpParser\Node\Stmt\Const_) {
                    foreach ($node->consts as $constNode) {
                        /** @psalm-suppress UndefinedPropertyFetch */
                        $constNodeName = $constNode->namespacedName->toString();
                        $this->constantNodes[$constNodeName] = $node;
                    }
                    return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
                    try {
                        \_HumbugBox221ad6f1b81f\Roave\BetterReflection\Util\ConstantNodeChecker::assertValidDefineFunctionCall($node);
                    } catch (\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Exception\InvalidConstantNode $e) {
                        return null;
                    }
                    $nameNode = $node->args[0]->value;
                    \assert($nameNode instanceof \PhpParser\Node\Scalar\String_);
                    $constantName = $nameNode->value;
                    if (\in_array($constantName, ['true', 'false', 'null'], \true)) {
                        $constantName = \strtoupper($constantName);
                        $nameNode->value = $constantName;
                    }
                    // Some constants has different values on different systems, some are not actual in stubs
                    if (\defined($constantName)) {
                        /** @var scalar|scalar[]|null $constantValue */
                        $constantValue = \constant($constantName);
                        $node->args[1]->value = \PhpParser\BuilderHelpers::normalizeValue($constantValue);
                    }
                    $this->constantNodes[$constantName] = $node;
                    if (\count($node->args) === 3 && $node->args[2]->value instanceof \PhpParser\Node\Expr\ConstFetch && $node->args[2]->value->name->toLowerString() === 'true') {
                        $this->constantNodes[\strtolower($constantName)] = $node;
                    }
                    return \PhpParser\NodeTraverser::DONT_TRAVERSE_CHILDREN;
                }
                return null;
            }
            /**
             * @return array<string, Node\Stmt\ClassLike>
             */
            public function getClassNodes() : array
            {
                return $this->classNodes;
            }
            /**
             * @return array<string, Node\Stmt\Function_>
             */
            public function getFunctionNodes() : array
            {
                return $this->functionNodes;
            }
            /**
             * @return array<string, Node\Stmt\Const_|Node\Expr\FuncCall>
             */
            public function getConstantNodes() : array
            {
                return $this->constantNodes;
            }
            public function clearNodes() : void
            {
                $this->classNodes = [];
                $this->functionNodes = [];
                $this->constantNodes = [];
            }
        };
    }
    private function getExtensionFromFilePath(string $filePath) : string
    {
        return \explode('/', $filePath)[0];
    }
    private function getAbsoluteFilePath(string $filePath) : string
    {
        return \sprintf('%s/%s', $this->getStubsDirectory(), $filePath);
    }
    private function getStubsDirectory() : string
    {
        if ($this->stubsDirectory !== null) {
            return $this->stubsDirectory;
        }
        foreach (self::SEARCH_DIRECTORIES as $directory) {
            if (\is_dir($directory)) {
                return $this->stubsDirectory = $directory;
            }
        }
        throw \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\SourceStubber\Exception\CouldNotFindPhpStormStubs::create();
    }
}
