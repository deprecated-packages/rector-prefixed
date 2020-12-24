<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\Core\Reflection\ClassMethodReflectionFactory;
use _PhpScoper0a6b37af0871\Rector\FileSystemRector\Parser\FileInfoParser;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see https://phpunit.readthedocs.io/en/7.3/annotations.html#doesnotperformassertions
 * @see https://github.com/sebastianbergmann/phpunit/issues/2484
 *
 * @see \Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\AddDoesNotPerformAssertionToNonAssertingTestRectorTest
 */
final class AddDoesNotPerformAssertionToNonAssertingTestRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractPHPUnitRector
{
    /**
     * @var int
     */
    private const MAX_LOOKING_FOR_ASSERT_METHOD_CALL_NESTING_LEVEL = 3;
    /**
     * @var string
     */
    private const DOES_NOT_PERFORM_ASSERTION_TAG = 'doesNotPerformAssertions';
    /**
     * @var string
     */
    private const EXPECTED_EXCEPTION_TAG = 'expectedException';
    /**
     * This should prevent segfaults while going too deep into to parsed code.
     * Without it, it might end-up with segfault
     * @var int
     */
    private $classMethodNestingLevel = 0;
    /**
     * @var bool[]
     */
    private $containsAssertCallByClassMethod = [];
    /**
     * @var FileInfoParser
     */
    private $fileInfoParser;
    /**
     * @var ClassMethodReflectionFactory
     */
    private $classMethodReflectionFactory;
    /**
     * @var ClassMethod[][]|null[][]
     */
    private $analyzedMethodsInFileName = [];
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\Reflection\ClassMethodReflectionFactory $classMethodReflectionFactory, \_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\PhpDoc\NodeAnalyzer\DocBlockManipulator $docBlockManipulator, \_PhpScoper0a6b37af0871\Rector\FileSystemRector\Parser\FileInfoParser $fileInfoParser)
    {
        $this->docBlockManipulator = $docBlockManipulator;
        $this->fileInfoParser = $fileInfoParser;
        $this->classMethodReflectionFactory = $classMethodReflectionFactory;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Tests without assertion will have @doesNotPerformAssertion', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeClass extends TestCase
{
    public function test()
    {
        $nothing = 5;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use PHPUnit\Framework\TestCase;

class SomeClass extends TestCase
{
    /**
     * @doesNotPerformAssertions
     */
    public function test()
    {
        $nothing = 5;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        $this->classMethodNestingLevel = 0;
        if ($this->shouldSkipClassMethod($node)) {
            return null;
        }
        $this->addDoesNotPerformAssertions($node);
        return $node;
    }
    private function shouldSkipClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        if (!$this->isInTestClass($classMethod)) {
            return \true;
        }
        if (!$this->isTestClassMethod($classMethod)) {
            return \true;
        }
        if ($this->hasTagByName($classMethod, self::DOES_NOT_PERFORM_ASSERTION_TAG)) {
            return \true;
        }
        if ($this->hasTagByName($classMethod, self::EXPECTED_EXCEPTION_TAG)) {
            return \true;
        }
        return $this->containsAssertCall($classMethod);
    }
    private function addDoesNotPerformAssertions(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        /** @var PhpDocInfo $phpDocInfo */
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        $phpDocInfo->addBareTag('@' . self::DOES_NOT_PERFORM_ASSERTION_TAG);
    }
    private function containsAssertCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        ++$this->classMethodNestingLevel;
        // probably no assert method in the end
        if ($this->classMethodNestingLevel > self::MAX_LOOKING_FOR_ASSERT_METHOD_CALL_NESTING_LEVEL) {
            return \false;
        }
        $cacheHash = \md5($this->print($classMethod));
        if (isset($this->containsAssertCallByClassMethod[$cacheHash])) {
            return $this->containsAssertCallByClassMethod[$cacheHash];
        }
        // A. try "->assert" shallow search first for performance
        $hasDirectAssertCall = $this->hasDirectAssertCall($classMethod);
        if ($hasDirectAssertCall) {
            $this->containsAssertCallByClassMethod[$cacheHash] = $hasDirectAssertCall;
            return $hasDirectAssertCall;
        }
        // B. look for nested calls
        $hasNestedAssertCall = $this->hasNestedAssertCall($classMethod);
        $this->containsAssertCallByClassMethod[$cacheHash] = $hasNestedAssertCall;
        return $hasNestedAssertCall;
    }
    private function hasDirectAssertCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->isNames($node->name, [
                // phpunit
                '*assert',
                'assert*',
                'expectException*',
                'setExpectedException*',
            ]);
        });
    }
    private function hasNestedAssertCall(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        $currentClassMethod = $classMethod;
        // over and over the same method :/
        return (bool) $this->betterNodeFinder->findFirst((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($currentClassMethod) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall && !$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            $classMethod = $this->findClassMethod($node);
            // skip circular self calls
            if ($currentClassMethod === $classMethod) {
                return \false;
            }
            if ($classMethod !== null) {
                return $this->containsAssertCall($classMethod);
            }
            return \false;
        });
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function findClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $classMethod = $this->nodeRepository->findClassMethodByMethodCall($node);
            if ($classMethod !== null) {
                return $classMethod;
            }
        } elseif ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
            $classMethod = $this->nodeRepository->findClassMethodByStaticCall($node);
            if ($classMethod !== null) {
                return $classMethod;
            }
        }
        // in 3rd-party code
        return $this->findClassMethodByParsingReflection($node);
    }
    /**
     * @param MethodCall|StaticCall $node
     */
    private function findClassMethodByParsingReflection(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $methodName = $this->getName($node->name);
        if ($methodName === null) {
            return null;
        }
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
            $objectType = $this->getObjectType($node->var);
        } else {
            // StaticCall
            $objectType = $this->getObjectType($node->class);
        }
        $reflectionMethod = $this->classMethodReflectionFactory->createFromPHPStanTypeAndMethodName($objectType, $methodName);
        if ($reflectionMethod === null) {
            return null;
        }
        $fileName = $reflectionMethod->getFileName();
        if (!$fileName || !\file_exists($fileName)) {
            return null;
        }
        return $this->findClassMethodInFile($fileName, $methodName);
    }
    private function findClassMethodInFile(string $fileName, string $methodName) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        // skip already anayzed method to prevent cycling
        if (isset($this->analyzedMethodsInFileName[$fileName][$methodName])) {
            return $this->analyzedMethodsInFileName[$fileName][$methodName];
        }
        $smartFileInfo = new \_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo($fileName);
        $examinedMethodNodes = $this->fileInfoParser->parseFileInfoToNodesAndDecorate($smartFileInfo);
        /** @var ClassMethod|null $examinedClassMethod */
        $examinedClassMethod = $this->betterNodeFinder->findFirst($examinedMethodNodes, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($methodName) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod) {
                return \false;
            }
            return $this->isName($node, $methodName);
        });
        $this->analyzedMethodsInFileName[$fileName][$methodName] = $examinedClassMethod;
        return $examinedClassMethod;
    }
}
