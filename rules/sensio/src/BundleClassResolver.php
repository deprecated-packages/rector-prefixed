<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Sensio;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser;
use _PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser\Parser;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
use ReflectionClass;
use _PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo;
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
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\BetterNodeFinder $betterNodeFinder, \_PhpScoper2a4e7ab1ecbc\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Parser\Parser $parser)
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
        $fileInfo = new \_PhpScoper2a4e7ab1ecbc\Symplify\SmartFileSystem\SmartFileInfo($filePath);
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
        $nodeTraverser = new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeTraverser();
        $nameResolver = new \_PhpScoper2a4e7ab1ecbc\PhpParser\NodeVisitor\NameResolver();
        $nodeTraverser->addVisitor($nameResolver);
        $nodeTraverser->traverse($nodes);
    }
}
