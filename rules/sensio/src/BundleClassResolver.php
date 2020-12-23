<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Sensio;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\NodeTraverser;
use _PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver;
use ReflectionClass;
use _PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo;
final class BundleClassResolver
{
    /**
     * @var Parser
     */
    private $parser;
    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper0a2ac50786fa\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper0a2ac50786fa\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Parser\Parser $parser)
    {
        $this->parser = $parser;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->classNaming = $classNaming;
        $this->nodeNameResolver = $nodeNameResolver;
    }
    public function resolveShortBundleClassFromControllerClass(string $class) : ?string
    {
        // resolve bundle from existing ones
        $reflectionClass = new \ReflectionClass($class);
        $fileName = $reflectionClass->getFileName();
        if (!$fileName) {
            return null;
        }
        $controllerDirectory = \dirname($fileName);
        $rootFolder = \getenv('SystemDrive', \true) . \DIRECTORY_SEPARATOR;
        // traverse up, un-till first bundle class appears
        $bundleFiles = [];
        while ($bundleFiles === [] && $controllerDirectory !== $rootFolder) {
            $bundleFiles = (array) \glob($controllerDirectory . '/**Bundle.php');
            $controllerDirectory = \dirname($controllerDirectory);
        }
        if ($bundleFiles === []) {
            return null;
        }
        /** @var string $bundleFile */
        $bundleFile = $bundleFiles[0];
        $bundleClassName = $this->resolveClassNameFromFilePath($bundleFile);
        if ($bundleClassName !== null) {
            return $this->classNaming->getShortName($bundleClassName);
        }
        return null;
    }
    private function resolveClassNameFromFilePath(string $filePath) : ?string
    {
        $fileInfo = new \_PhpScoper0a2ac50786fa\Symplify\SmartFileSystem\SmartFileInfo($filePath);
        $nodes = $this->parser->parseFileInfo($fileInfo);
        $this->addFullyQualifiedNamesToNodes($nodes);
        $class = $this->betterNodeFinder->findFirstNonAnonymousClass($nodes);
        if ($class === null) {
            return null;
        }
        return $this->nodeNameResolver->getName($class);
    }
    /**
     * @param Node[] $nodes
     */
    private function addFullyQualifiedNamesToNodes(array $nodes) : void
    {
        $nodeTraverser = new \_PhpScoper0a2ac50786fa\PhpParser\NodeTraverser();
        $nameResolver = new \_PhpScoper0a2ac50786fa\PhpParser\NodeVisitor\NameResolver();
        $nodeTraverser->addVisitor($nameResolver);
        $nodeTraverser->traverse($nodes);
    }
}
