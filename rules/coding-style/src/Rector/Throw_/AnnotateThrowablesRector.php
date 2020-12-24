<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\Throw_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_;
use _PhpScopere8e811afab72\Rector\BetterPhpDocParser\PhpDocInfo\PhpDocInfo;
use _PhpScopere8e811afab72\Rector\CodingStyle\DocBlock\ThrowsFactory;
use _PhpScopere8e811afab72\Rector\CodingStyle\NodeAnalyzer\ThrowAnalyzer;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ClassResolver;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Core\Reflection\ClassMethodReflectionHelper;
use _PhpScopere8e811afab72\Rector\Core\Reflection\FunctionAnnotationResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use ReflectionFunction;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Throw_\AnnotateThrowablesRector\AnnotateThrowablesRectorTest
 */
final class AnnotateThrowablesRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function __construct(\_PhpScopere8e811afab72\Rector\Core\Reflection\ClassMethodReflectionHelper $classMethodReflectionHelper, \_PhpScopere8e811afab72\Rector\Core\PhpParser\Node\Value\ClassResolver $classResolver, \_PhpScopere8e811afab72\Rector\Core\Reflection\FunctionAnnotationResolver $functionAnnotationResolver, \_PhpScopere8e811afab72\Rector\CodingStyle\NodeAnalyzer\ThrowAnalyzer $throwAnalyzer, \_PhpScopere8e811afab72\Rector\CodingStyle\DocBlock\ThrowsFactory $throwsFactory)
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * From this method documentation is generated.
     */
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Adds @throws DocBlock comments to methods that thrwo \\Throwables.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(
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
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
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
    private function hasThrowablesToAnnotate(\_PhpScopere8e811afab72\PhpParser\Node $node) : bool
    {
        $foundThrowables = 0;
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_) {
            $foundThrowables = $this->analyzeStmtThrow($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall) {
            $foundThrowables = $this->analyzeStmtFuncCall($node);
        }
        if ($node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall) {
            $foundThrowables = $this->analyzeStmtMethodCall($node);
        }
        return $foundThrowables > 0;
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    private function annotateThrowables(\_PhpScopere8e811afab72\PhpParser\Node $node) : void
    {
        $callee = $this->identifyCaller($node);
        if ($callee === null) {
            return;
        }
        $phpDocInfo = $callee->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        foreach ($this->throwablesToAnnotate as $throwableToAnnotate) {
            $docComment = $this->throwsFactory->crateDocTagNodeFromClass($throwableToAnnotate);
            $phpDocInfo->addPhpDocTagNode($docComment);
        }
    }
    private function analyzeStmtThrow(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Throw_ $throw) : int
    {
        $foundThrownThrowables = $this->throwAnalyzer->resolveThrownTypes($throw);
        $alreadyAnnotatedThrowables = $this->extractAlreadyAnnotatedThrowables($throw);
        return $this->diffThrowsTypes($foundThrownThrowables, $alreadyAnnotatedThrowables);
    }
    private function analyzeStmtFuncCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\FuncCall $funcCall) : int
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
    private function analyzeStmtMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : int
    {
        $foundThrowsTypes = $this->identifyThrownThrowablesInMethodCall($methodCall);
        $alreadyAnnotatedThrowsTypes = $this->extractAlreadyAnnotatedThrowables($methodCall);
        return $this->diffThrowsTypes($foundThrowsTypes, $alreadyAnnotatedThrowsTypes);
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     */
    private function identifyCaller(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->betterNodeFinder->findFirstAncestorInstancesOf($node, [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class]);
    }
    /**
     * @param Throw_|MethodCall|FuncCall $node
     * @return class-string[]
     */
    private function extractAlreadyAnnotatedThrowables(\_PhpScopere8e811afab72\PhpParser\Node $node) : array
    {
        $callee = $this->identifyCaller($node);
        if ($callee === null) {
            return [];
        }
        /** @var PhpDocInfo|null $callePhpDocInfo */
        $callePhpDocInfo = $callee->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($callePhpDocInfo === null) {
            return [];
        }
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
    private function identifyThrownThrowablesInMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : array
    {
        $fullyQualified = $this->classResolver->getClassFromMethodCall($methodCall);
        $methodName = $methodCall->name;
        if (!$fullyQualified instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified || !$methodName instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
            return [];
        }
        return $this->extractMethodThrows($fullyQualified, $methodName);
    }
    /**
     * @return class-string[]
     */
    private function extractMethodThrows(\_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified $fullyQualified, \_PhpScopere8e811afab72\PhpParser\Node\Identifier $identifier) : array
    {
        $method = $identifier->name;
        $class = $this->getName($fullyQualified);
        if ($class === null) {
            return [];
        }
        return $this->classMethodReflectionHelper->extractTagsFromMethodDocBlock($class, $method);
    }
}
