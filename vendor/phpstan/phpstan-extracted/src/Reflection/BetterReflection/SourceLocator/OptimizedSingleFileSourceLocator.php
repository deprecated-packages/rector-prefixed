<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
class OptimizedSingleFileSourceLocator implements \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher */
    private $fileNodesFetcher;
    /** @var string */
    private $fileName;
    /** @var \PHPStan\Reflection\BetterReflection\SourceLocator\FetchedNodesResult|null */
    private $fetchedNodesResult = null;
    public function __construct(\_PhpScoper0a2ac50786fa\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher, string $fileName)
    {
        $this->fileNodesFetcher = $fileNodesFetcher;
        $this->fileName = $fileName;
    }
    public function locateIdentifier(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        if ($this->fetchedNodesResult === null) {
            $this->fetchedNodesResult = $this->fileNodesFetcher->fetchNodes($this->fileName);
        }
        $nodeToReflection = new \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
        if ($identifier->isClass()) {
            $classNodes = $this->fetchedNodesResult->getClassNodes();
            $className = \strtolower($identifier->getName());
            if (!\array_key_exists($className, $classNodes)) {
                return null;
            }
            foreach ($classNodes[$className] as $classNode) {
                $classReflection = $nodeToReflection->__invoke($reflector, $classNode->getNode(), $this->fetchedNodesResult->getLocatedSource(), $classNode->getNamespace());
                if (!$classReflection instanceof \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionClass) {
                    throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
                }
                return $classReflection;
            }
        }
        if ($identifier->isFunction()) {
            $functionNodes = $this->fetchedNodesResult->getFunctionNodes();
            $functionName = \strtolower($identifier->getName());
            if (!\array_key_exists($functionName, $functionNodes)) {
                return null;
            }
            $functionReflection = $nodeToReflection->__invoke($reflector, $functionNodes[$functionName]->getNode(), $this->fetchedNodesResult->getLocatedSource(), $functionNodes[$functionName]->getNamespace());
            if (!$functionReflection instanceof \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunction) {
                throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
            }
            return $functionReflection;
        }
        if ($identifier->isConstant()) {
            $constantNodes = $this->fetchedNodesResult->getConstantNodes();
            foreach ($constantNodes as $stmtConst) {
                if ($stmtConst->getNode() instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\FuncCall) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->fetchedNodesResult->getLocatedSource(), $stmtConst->getNamespace());
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
                foreach (\array_keys($stmtConst->getNode()->consts) as $i) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->fetchedNodesResult->getLocatedSource(), $stmtConst->getNamespace(), $i);
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
            }
            return null;
        }
        throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException();
    }
    public function locateIdentifiersByType(\_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper0a2ac50786fa\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
    }
}
