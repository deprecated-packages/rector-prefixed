<?php

declare (strict_types=1);
namespace Rector\CodingStyle\Rector\Throw_;

use PhpParser\Node;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Throw_;
use Rector\CodingStyle\DocBlock\ThrowsFactory;
use Rector\CodingStyle\NodeAnalyzer\ThrowAnalyzer;
use Rector\Core\PhpParser\Node\Value\ClassResolver;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\Reflection\ClassMethodReflectionHelper;
use Rector\Core\Reflection\FunctionAnnotationResolver;
use ReflectionFunction;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\AnnotateThrowablesRectorTest
 */
final class AnnotateThrowablesRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string[]
     */
    private $throwablesToAnnotate = [];
    /**
     * @var FunctionAnnotationResolver
     */
    private $functionAnnotationResolver;
    /**
     * @var ClassMethodReflectionHelper
     */
    private $classMethodReflectionHelper;
    /**
     * @var ClassResolver
     */
    private $classResolver;
    /**
     * @var ThrowAnalyzer
     */
    private $throwAnalyzer;
    /**
     * @var ThrowsFactory
     */
    private $throwsFactory;
    public function __construct(\Rector\Core\Reflection\ClassMethodReflectionHelper $classMethodReflectionHelper, \Rector\Core\PhpParser\Node\Value\ClassResolver $classResolver, \Rector\Core\Reflection\FunctionAnnotationResolver $functionAnnotationResolver, \Rector\CodingStyle\NodeAnalyzer\ThrowAnalyzer $throwAnalyzer, \Rector\CodingStyle\DocBlock\ThrowsFactory $throwsFactory)
    {
        $this->functionAnnotationResolver = $functionAnnotationResolver;
        $this->classMethodReflectionHelper = $classMethodReflectionHelper;
        $this->classResolver = $classResolver;
        $this->throwAnalyzer = $throwAnalyzer;
        $this->throwsFactory = $throwsFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Stmt\Throw_::class, \PhpParser\Node\Expr\FuncCall::class, \PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * From this method documentation is generated.
     */
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @throws DocBlock comments to methods that thrwo \\Throwables.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(
            // code before
            <<<'CODE_SAMPLE'
class RootExceptionInMethodWithDocblock
{
    /**
     * This is a comment.
     *
     * @param int $code
     */
    public function throwException(int $code)
    {
        throw new \RuntimeException('', $code);
    }
}
CODE_SAMPLE
,
            // code after
            <<<'CODE_SAMPLE'
class RootExceptionInMethodWithDocblock
{
    /**
     * This is a comment.
     *
     * @param int $code
     * @throws \RuntimeException
     */
    public function throwException(int $code)
    {
        throw new \RuntimeException('', $code);
    }
}
CODE_SAMPLE

        )]);
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        $this->throwablesToAnnotate = [];
        if ($this->hasThrowablesToAnnotate($node)) {
            $this->annotateThrowables($node);
            return $node;
        }
        return null;
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    private function hasThrowablesToAnnotate(\PhpParser\Node $node) : bool
    {
        $foundThrowables = 0;
        if ($node instanceof \PhpParser\Node\Stmt\Throw_) {
            $foundThrowables = $this->analyzeStmtThrow($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\FuncCall) {
            $foundThrowables = $this->analyzeStmtFuncCall($node);
        }
        if ($node instanceof \PhpParser\Node\Expr\MethodCall) {
            $foundThrowables = $this->analyzeStmtMethodCall($node);
        }
        return $foundThrowables > 0;
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    private function annotateThrowables(\PhpParser\Node $node) : void
    {
        $callee = $this->identifyCaller($node);
        if (!$callee instanceof \PhpParser\Node) {
            return;
        }
        $phpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($callee);
        foreach ($this->throwablesToAnnotate as $throwableToAnnotate) {
            $phpDocTagNode = $this->throwsFactory->crateDocTagNodeFromClass($throwableToAnnotate);
            $phpDocInfo->addPhpDocTagNode($phpDocTagNode);
        }
    }
    private function analyzeStmtThrow(\PhpParser\Node\Stmt\Throw_ $throw) : int
    {
        $foundThrownThrowables = $this->throwAnalyzer->resolveThrownTypes($throw);
        $alreadyAnnotatedThrowables = $this->extractAlreadyAnnotatedThrowables($throw);
        return $this->diffThrowsTypes($foundThrownThrowables, $alreadyAnnotatedThrowables);
    }
    private function analyzeStmtFuncCall(\PhpParser\Node\Expr\FuncCall $funcCall) : int
    {
        $functionFqn = $this->getName($funcCall);
        if ($functionFqn === null) {
            return 0;
        }
        $reflectionFunction = new \ReflectionFunction($functionFqn);
        $throwsTypes = $this->functionAnnotationResolver->extractFunctionAnnotatedThrows($reflectionFunction);
        $alreadyAnnotatedThrowsTypes = $this->extractAlreadyAnnotatedThrowables($funcCall);
        return $this->diffThrowsTypes($throwsTypes, $alreadyAnnotatedThrowsTypes);
    }
    private function analyzeStmtMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : int
    {
        $foundThrowsTypes = $this->identifyThrownThrowablesInMethodCall($methodCall);
        $alreadyAnnotatedThrowsTypes = $this->extractAlreadyAnnotatedThrowables($methodCall);
        return $this->diffThrowsTypes($foundThrowsTypes, $alreadyAnnotatedThrowsTypes);
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    private function identifyCaller(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstAncestorInstancesOf($node, [\PhpParser\Node\Stmt\ClassMethod::class, \PhpParser\Node\Stmt\Function_::class]);
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     * @return string[]
     */
    private function extractAlreadyAnnotatedThrowables(\PhpParser\Node $node) : array
    {
        $callee = $this->identifyCaller($node);
        if (!$callee instanceof \PhpParser\Node) {
            return [];
        }
        $callePhpDocInfo = $this->phpDocInfoFactory->createFromNodeOrEmpty($callee);
        return $callePhpDocInfo->getThrowsClassNames();
    }
    /**
     * @param string[] $foundThrownThrowables
     * @param string[] $alreadyAnnotatedThrowables
     */
    private function diffThrowsTypes(array $foundThrownThrowables, array $alreadyAnnotatedThrowables) : int
    {
        $normalizeNamespace = static function (string $class) : string {
            $class = \ltrim($class, '\\');
            return '\\' . $class;
        };
        $foundThrownThrowables = \array_map($normalizeNamespace, $foundThrownThrowables);
        $alreadyAnnotatedThrowables = \array_map($normalizeNamespace, $alreadyAnnotatedThrowables);
        $filterClasses = static function (string $class) : bool {
            return \class_exists($class) || \interface_exists($class);
        };
        $foundThrownThrowables = \array_filter($foundThrownThrowables, $filterClasses);
        $alreadyAnnotatedThrowables = \array_filter($alreadyAnnotatedThrowables, $filterClasses);
        $this->throwablesToAnnotate = \array_diff($foundThrownThrowables, $alreadyAnnotatedThrowables);
        return \count($this->throwablesToAnnotate);
    }
    /**
     * @return class-string[]
     */
    private function identifyThrownThrowablesInMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $fullyQualified = $this->classResolver->getClassFromMethodCall($methodCall);
        $methodName = $methodCall->name;
        if (!$fullyQualified instanceof \PhpParser\Node\Name\FullyQualified) {
            return [];
        }
        if (!$methodName instanceof \PhpParser\Node\Identifier) {
            return [];
        }
        return $this->extractMethodThrows($fullyQualified, $methodName);
    }
    /**
     * @return class-string[]
     */
    private function extractMethodThrows(\PhpParser\Node\Name\FullyQualified $fullyQualified, \PhpParser\Node\Identifier $identifier) : array
    {
        $method = $identifier->name;
        $class = $this->getName($fullyQualified);
        if ($class === null) {
            return [];
        }
        return $this->classMethodReflectionHelper->extractTagsFromMethodDocBlock($class, $method);
    }
}
