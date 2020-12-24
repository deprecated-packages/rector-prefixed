<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Legacy\Rector\FileWithoutNamespace;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Legacy\Naming\FullyQualifiedNameResolver;
use _PhpScoper0a6b37af0871\Rector\Legacy\NodeFactory\StaticMethodClassFactory;
use _PhpScoper0a6b37af0871\Rector\Legacy\ValueObject\FunctionToStaticCall;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo;
/**
 * @see \Rector\Legacy\Tests\Rector\FileWithoutNamespace\FunctionToStaticMethodRector\FunctionToStaticMethodRectorTest
 */
final class FunctionToStaticMethodRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var ClassNaming
     */
    private $classNaming;
    /**
     * @var StaticMethodClassFactory
     */
    private $staticMethodClassFactory;
    /**
     * @var FullyQualifiedNameResolver
     */
    private $fullyQualifiedNameResolver;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\CodingStyle\Naming\ClassNaming $classNaming, \_PhpScoper0a6b37af0871\Rector\Legacy\NodeFactory\StaticMethodClassFactory $staticMethodClassFactory, \_PhpScoper0a6b37af0871\Rector\Legacy\Naming\FullyQualifiedNameResolver $fullyQualifiedNameResolver)
    {
        $this->classNaming = $classNaming;
        $this->staticMethodClassFactory = $staticMethodClassFactory;
        $this->fullyQualifiedNameResolver = $fullyQualifiedNameResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change functions to static calls, so composer can autoload them', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
function some_function()
{
}

some_function('lol');
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class SomeUtilsClass
{
    public static function someFunction()
    {
    }
}

SomeUtilsClass::someFunction('lol');
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        /** @var Function_[] $functions */
        $functions = $this->betterNodeFinder->findInstanceOf($node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Function_::class);
        if ($functions === []) {
            return null;
        }
        $smartFileInfo = $node->getAttribute(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo::class);
        if ($smartFileInfo === null) {
            return null;
        }
        $shortClassName = $this->classNaming->getNameFromFileInfo($smartFileInfo);
        $class = $this->staticMethodClassFactory->createStaticMethodClass($shortClassName, $functions);
        $stmts = $node->stmts;
        $this->removeNodes($functions);
        // replace function calls with class static call
        $functionsToStaticCalls = $this->resolveFunctionsToStaticCalls($stmts, $shortClassName, $functions);
        $node->stmts = $this->replaceFuncCallsWithStaticCalls($stmts, $functionsToStaticCalls);
        $this->printStaticMethodClass($smartFileInfo, $shortClassName, $node, $class);
        return $node;
    }
    /**
     * @param Node[] $stmts
     * @param Function_[] $functions
     * @return FunctionToStaticCall[]
     */
    private function resolveFunctionsToStaticCalls(array $stmts, string $shortClassName, array $functions) : array
    {
        $functionsToStaticCalls = [];
        $className = $this->fullyQualifiedNameResolver->resolveFullyQualifiedName($stmts, $shortClassName);
        foreach ($functions as $function) {
            $functionName = $this->getName($function);
            if ($functionName === null) {
                continue;
            }
            $methodName = $this->classNaming->createMethodNameFromFunction($function);
            $functionsToStaticCalls[] = new \_PhpScoper0a6b37af0871\Rector\Legacy\ValueObject\FunctionToStaticCall($functionName, $className, $methodName);
        }
        return $functionsToStaticCalls;
    }
    /**
     * @param Node[] $stmts
     * @param FunctionToStaticCall[] $functionsToStaticCalls
     * @return Node[]
     */
    private function replaceFuncCallsWithStaticCalls(array $stmts, array $functionsToStaticCalls) : array
    {
        $this->traverseNodesWithCallable($stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) use($functionsToStaticCalls) : ?StaticCall {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\FuncCall) {
                return null;
            }
            foreach ($functionsToStaticCalls as $functionToStaticCall) {
                if (!$this->isName($node, $functionToStaticCall->getFunction())) {
                    continue;
                }
                $staticCall = $this->createStaticCall($functionToStaticCall->getClass(), $functionToStaticCall->getMethod());
                $staticCall->args = $node->args;
                return $staticCall;
            }
            return null;
        });
        return $stmts;
    }
    /**
     * @param Namespace_|FileWithoutNamespace $node
     */
    private function printStaticMethodClass(\_PhpScoper0a6b37af0871\Symplify\SmartFileSystem\SmartFileInfo $smartFileInfo, string $shortClassName, \_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : void
    {
        $classFileDestination = $smartFileInfo->getPath() . \DIRECTORY_SEPARATOR . $shortClassName . '.php';
        $nodesToPrint = [$this->resolveNodeToPrint($node, $class)];
        $this->printNodesToFilePath($nodesToPrint, $classFileDestination);
    }
    /**
     * @param Namespace_|FileWithoutNamespace $node
     * @return Namespace_|Class_
     */
    private function resolveNodeToPrint(\_PhpScoper0a6b37af0871\PhpParser\Node $node, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_) {
            return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_($node->name, [$class]);
        }
        return $class;
    }
}
