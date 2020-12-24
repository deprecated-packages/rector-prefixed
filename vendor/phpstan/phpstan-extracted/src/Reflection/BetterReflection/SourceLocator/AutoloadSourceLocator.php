<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BetterReflection\SourceLocator;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Exception\ParseToAstFailure;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource;
use _PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator;
use function array_key_exists;
use function file_exists;
use function restore_error_handler;
/**
 * Use PHP's built in autoloader to locate a class, without actually loading.
 *
 * There are some prerequisites...
 *   - we expect the autoloader to load classes from a file (i.e. using require/include)
 *
 * Modified code from Roave/BetterReflection, Copyright (c) 2017 Roave, LLC.
 */
class AutoloadSourceLocator implements \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\SourceLocator
{
    /** @var FileNodesFetcher */
    private $fileNodesFetcher;
    /** @var array<string, array<FetchedNode<\PhpParser\Node\Stmt\ClassLike>>> */
    private $classNodes = [];
    /** @var array<string, Reflection|null> */
    private $classReflections = [];
    /** @var array<string, FetchedNode<\PhpParser\Node\Stmt\Function_>> */
    private $functionNodes = [];
    /** @var array<int, FetchedNode<\PhpParser\Node\Stmt\Const_|\PhpParser\Node\Expr\FuncCall>> */
    private $constantNodes = [];
    /** @var array<string, \Roave\BetterReflection\SourceLocator\Located\LocatedSource> */
    private $locatedSourcesByFile = [];
    public function __construct(\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BetterReflection\SourceLocator\FileNodesFetcher $fileNodesFetcher)
    {
        $this->fileNodesFetcher = $fileNodesFetcher;
    }
    /**
     * {@inheritDoc}
     *
     * @throws ParseToAstFailure
     */
    public function locateIdentifier(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : ?\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        if ($identifier->isFunction()) {
            $functionName = $identifier->getName();
            $loweredFunctionName = \strtolower($functionName);
            if (\array_key_exists($loweredFunctionName, $this->functionNodes)) {
                $nodeToReflection = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
                return $nodeToReflection->__invoke($reflector, $this->functionNodes[$loweredFunctionName]->getNode(), $this->locatedSourcesByFile[$this->functionNodes[$loweredFunctionName]->getFileName()], $this->functionNodes[$loweredFunctionName]->getNamespace());
            }
            if (!\function_exists($functionName)) {
                return null;
            }
            $reflection = new \ReflectionFunction($functionName);
            $reflectionFileName = $reflection->getFileName();
            if (!\is_string($reflectionFileName)) {
                return null;
            }
            if (!\file_exists($reflectionFileName)) {
                return null;
            }
            return $this->findReflection($reflector, $reflectionFileName, $identifier, null);
        }
        if ($identifier->isConstant()) {
            $constantName = $identifier->getName();
            $nodeToReflection = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
            foreach ($this->constantNodes as $stmtConst) {
                if ($stmtConst->getNode() instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->locatedSourcesByFile[$stmtConst->getFileName()], $stmtConst->getNamespace());
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
                foreach (\array_keys($stmtConst->getNode()->consts) as $i) {
                    $constantReflection = $nodeToReflection->__invoke($reflector, $stmtConst->getNode(), $this->locatedSourcesByFile[$stmtConst->getFileName()], $stmtConst->getNamespace(), $i);
                    if ($constantReflection === null) {
                        continue;
                    }
                    if (!$constantReflection instanceof \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant) {
                        throw new \_PhpScoper2a4e7ab1ecbc\PHPStan\ShouldNotHappenException();
                    }
                    if ($constantReflection->getName() !== $identifier->getName()) {
                        continue;
                    }
                    return $constantReflection;
                }
            }
            if (!\defined($constantName)) {
                return null;
            }
            $reflection = \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionConstant::createFromNode($reflector, new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\FuncCall(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Name('define'), [new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_($constantName)), new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Arg(new \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_(''))]), new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Located\LocatedSource('', null), null, null);
            $reflection->populateValue(\constant($constantName));
            return $reflection;
        }
        if (!$identifier->isClass()) {
            return null;
        }
        $loweredClassName = \strtolower($identifier->getName());
        if (\array_key_exists($loweredClassName, $this->classReflections)) {
            return $this->classReflections[$loweredClassName];
        }
        $locateResult = $this->locateClassByName($identifier->getName());
        if ($locateResult === null) {
            if (\array_key_exists($loweredClassName, $this->classNodes)) {
                foreach ($this->classNodes[$loweredClassName] as $classNode) {
                    $nodeToReflection = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
                    return $this->classReflections[$loweredClassName] = $nodeToReflection->__invoke($reflector, $classNode->getNode(), $this->locatedSourcesByFile[$classNode->getFileName()], $classNode->getNamespace());
                }
            }
            return null;
        }
        [$potentiallyLocatedFile, $className, $startLine] = $locateResult;
        return $this->findReflection($reflector, $potentiallyLocatedFile, new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier($className, $identifier->getType()), $startLine);
    }
    private function findReflection(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, string $file, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier, ?int $startLine) : ?\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\Reflection
    {
        if (!\array_key_exists($file, $this->locatedSourcesByFile)) {
            $result = $this->fileNodesFetcher->fetchNodes($file);
            $this->locatedSourcesByFile[$file] = $result->getLocatedSource();
            foreach ($result->getClassNodes() as $className => $fetchedClassNodes) {
                foreach ($fetchedClassNodes as $fetchedClassNode) {
                    $this->classNodes[$className][] = $fetchedClassNode;
                }
            }
            foreach ($result->getFunctionNodes() as $functionName => $fetchedFunctionNode) {
                $this->functionNodes[$functionName] = $fetchedFunctionNode;
            }
            foreach ($result->getConstantNodes() as $fetchedConstantNode) {
                $this->constantNodes[] = $fetchedConstantNode;
            }
            $locatedSource = $result->getLocatedSource();
        } else {
            $locatedSource = $this->locatedSourcesByFile[$file];
        }
        $nodeToReflection = new \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Ast\Strategy\NodeToReflection();
        if ($identifier->isClass()) {
            $identifierName = \strtolower($identifier->getName());
            if (\array_key_exists($identifierName, $this->classReflections)) {
                return $this->classReflections[$identifierName];
            }
            if (!\array_key_exists($identifierName, $this->classNodes)) {
                return null;
            }
            foreach ($this->classNodes[$identifierName] as $classNode) {
                if ($startLine !== null) {
                    if (\count($classNode->getNode()->attrGroups) > 0 && \PHP_VERSION_ID < 80000) {
                        $startLine--;
                    }
                    if ($startLine !== $classNode->getNode()->getStartLine()) {
                        continue;
                    }
                }
                return $this->classReflections[$identifierName] = $nodeToReflection->__invoke($reflector, $classNode->getNode(), $locatedSource, $classNode->getNamespace());
            }
            return null;
        }
        if ($identifier->isFunction()) {
            $identifierName = \strtolower($identifier->getName());
            if (!\array_key_exists($identifierName, $this->functionNodes)) {
                return null;
            }
            return $nodeToReflection->__invoke($reflector, $this->functionNodes[$identifierName]->getNode(), $locatedSource, $this->functionNodes[$identifierName]->getNamespace());
        }
        return null;
    }
    public function locateIdentifiersByType(\_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflector\Reflector $reflector, \_PhpScoper2a4e7ab1ecbc\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\IdentifierType $identifierType) : array
    {
        return [];
    }
    /**
     * Attempt to locate a class by name.
     *
     * If class already exists, simply use internal reflection API to get the
     * filename and store it.
     *
     * If class does not exist, we make an assumption that whatever autoloaders
     * that are registered will be loading a file. We then override the file://
     * protocol stream wrapper to "capture" the filename we expect the class to
     * be in, and then restore it. Note that class_exists will cause an error
     * that it cannot find the file, so we squelch the errors by overriding the
     * error handler temporarily.
     *
     * @throws ReflectionException
     * @return array{string, string, int|null}|null
     */
    private function locateClassByName(string $className) : ?array
    {
        if (\class_exists($className, \false) || \interface_exists($className, \false) || \trait_exists($className, \false)) {
            $reflection = new \ReflectionClass($className);
            $filename = $reflection->getFileName();
            if (!\is_string($filename)) {
                return null;
            }
            if (!\file_exists($filename)) {
                return null;
            }
            return [$filename, $reflection->getName(), $reflection->getStartLine() !== \false ? $reflection->getStartLine() : null];
        }
        $this->silenceErrors();
        try {
            /** @var array{string, string, null}|null */
            return \_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BetterReflection\SourceLocator\FileReadTrapStreamWrapper::withStreamWrapperOverride(static function () use($className) : ?array {
                $functions = \spl_autoload_functions();
                if ($functions === \false) {
                    return null;
                }
                foreach ($functions as $preExistingAutoloader) {
                    $preExistingAutoloader($className);
                    /**
                     * This static variable is populated by the side-effect of the stream wrapper
                     * trying to read the file path when `include()` is used by an autoloader.
                     *
                     * This will not be `null` when the autoloader tried to read a file.
                     */
                    if (\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BetterReflection\SourceLocator\FileReadTrapStreamWrapper::$autoloadLocatedFile !== null) {
                        return [\_PhpScoper2a4e7ab1ecbc\PHPStan\Reflection\BetterReflection\SourceLocator\FileReadTrapStreamWrapper::$autoloadLocatedFile, $className, null];
                    }
                }
                return null;
            });
        } finally {
            \restore_error_handler();
        }
    }
    private function silenceErrors() : void
    {
        \set_error_handler(static function () : bool {
            return \true;
        });
    }
}
