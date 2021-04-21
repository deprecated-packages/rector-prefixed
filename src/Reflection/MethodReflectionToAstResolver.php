<?php

declare(strict_types=1);

namespace Rector\Core\Reflection;

use Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PHPStan\Reflection\Php\PhpMethodReflection;
use Rector\Core\PhpParser\Node\BetterNodeFinder;
use Rector\FileSystemRector\Parser\FileInfoParser;
use Rector\NodeNameResolver\NodeNameResolver;
use Symplify\SmartFileSystem\SmartFileInfo;

final class MethodReflectionToAstResolver
{
    /**
     * @var FileInfoParser
     */
    private $fileInfoParser;

    /**
     * @var BetterNodeFinder
     */
    private $betterNodeFinder;

    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;

    /**
     * @var array<string, array<string, ClassMethod>>
     */
    private $analyzedMethodsInFileName = [];

    public function __construct(
        FileInfoParser $fileInfoParser,
        BetterNodeFinder $betterNodeFinder,
        NodeNameResolver $nodeNameResolver
    ) {
        $this->fileInfoParser = $fileInfoParser;
        $this->betterNodeFinder = $betterNodeFinder;
        $this->nodeNameResolver = $nodeNameResolver;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function resolveProjectClassMethod(PhpMethodReflection $phpMethodReflection)
    {
        $classReflection = $phpMethodReflection->getDeclaringClass();

        $fileName = $classReflection->getFileName();
        if ($fileName === false) {
            return null;
        }

        // skip vendor
        if (Strings::contains($fileName, '#\/vendor\/#')) {
            return null;
        }

        $methodName = $phpMethodReflection->getName();

        // skip already anayzed method to prevent cycling
        if (isset($this->analyzedMethodsInFileName[$fileName][$methodName])) {
            return $this->analyzedMethodsInFileName[$fileName][$methodName];
        }

        $smartFileInfo = new SmartFileInfo($fileName);

        $nodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($smartFileInfo);

        /** @var ClassMethod|null $classMethod */
        $classMethod = $this->betterNodeFinder->findFirst(
            $nodes,
            function (Node $node) use ($methodName): bool {
                if (! $node instanceof ClassMethod) {
                    return false;
                }

                return $this->nodeNameResolver->isName($node, $methodName);
            }
        );

        $this->analyzedMethodsInFileName[$fileName][$methodName] = $classMethod;

        return $classMethod;
    }
}
