<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Transform\Rector\StaticCall;

use _PhpScoperb75b35f52b74\PhpParser\Node;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall;
use _PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_;
use _PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoperb75b35f52b74\Rector\Generic\Rector\AbstractToMethodCallRector;
use _PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToMethodCall;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use _PhpScoperb75b35f52b74\Webmozart\Assert\Assert;
/**
 * @see \Rector\Transform\Tests\Rector\StaticCall\StaticCallToMethodCallRector\StaticCallToMethodCallRectorTest
 */
final class StaticCallToMethodCallRector extends \_PhpScoperb75b35f52b74\Rector\Generic\Rector\AbstractToMethodCallRector
{
    /**
     * @api
     * @var string
     */
    public const STATIC_CALLS_TO_METHOD_CALLS = 'static_calls_to_method_calls';
    /**
     * @var StaticCallToMethodCall[]
     */
    private $staticCallsToMethodCalls = [];
    public function getRuleDefinition() : \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change static call to service method via constructor injection', [new \_PhpScoperb75b35f52b74\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
use Nette\Utils\FileSystem;

class SomeClass
{
    public function run()
    {
        return FileSystem::write('file', 'content');
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symplify\SmartFileSystem\SmartFileSystem;

class SomeClass
{
    /**
     * @var SmartFileSystem
     */
    private $smartFileSystem;

    public function __construct(SmartFileSystem $smartFileSystem)
    {
        $this->smartFileSystem = $smartFileSystem;
    }

    public function run()
    {
        return $this->smartFileSystem->dumpFile('file', 'content');
    }
}
CODE_SAMPLE
, [self::STATIC_CALLS_TO_METHOD_CALLS => [new \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToMethodCall('_PhpScoperb75b35f52b74\\Nette\\Utils\\FileSystem', 'write', '_PhpScoperb75b35f52b74\\Symplify\\SmartFileSystem\\SmartFileSystem', 'dumpFile')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall::class];
    }
    /**
     * @param StaticCall $node
     */
    public function refactor(\_PhpScoperb75b35f52b74\PhpParser\Node $node) : ?\_PhpScoperb75b35f52b74\PhpParser\Node
    {
        $classLike = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $classMethod = $node->getAttribute(\_PhpScoperb75b35f52b74\Rector\NodeTypeResolver\Node\AttributeKey::METHOD_NODE);
        if (!$classMethod instanceof \_PhpScoperb75b35f52b74\PhpParser\Node\Stmt\ClassMethod) {
            return null;
        }
        foreach ($this->staticCallsToMethodCalls as $staticCallToMethodCall) {
            if (!$staticCallToMethodCall->isStaticCallMatch($node)) {
                continue;
            }
            if ($classMethod->isStatic()) {
                return $this->refactorToInstanceCall($node, $staticCallToMethodCall);
            }
            $expr = $this->matchTypeProvidingExpr($classLike, $classMethod, $staticCallToMethodCall->getClassType());
            if ($staticCallToMethodCall->getMethodName() === '*') {
                $methodName = $this->getName($node->name);
            } else {
                $methodName = $staticCallToMethodCall->getMethodName();
            }
            if (!\is_string($methodName)) {
                throw new \_PhpScoperb75b35f52b74\Rector\Core\Exception\ShouldNotHappenException();
            }
            return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($expr, $methodName, $node->args);
        }
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $staticCallsToMethodCalls = $configuration[self::STATIC_CALLS_TO_METHOD_CALLS] ?? [];
        \_PhpScoperb75b35f52b74\Webmozart\Assert\Assert::allIsInstanceOf($staticCallsToMethodCalls, \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToMethodCall::class);
        $this->staticCallsToMethodCalls = $staticCallsToMethodCalls;
    }
    private function refactorToInstanceCall(\_PhpScoperb75b35f52b74\PhpParser\Node\Expr\StaticCall $staticCall, \_PhpScoperb75b35f52b74\Rector\Transform\ValueObject\StaticCallToMethodCall $staticCallToMethodCall) : \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall
    {
        $new = new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\New_(new \_PhpScoperb75b35f52b74\PhpParser\Node\Name\FullyQualified($staticCallToMethodCall->getClassType()));
        return new \_PhpScoperb75b35f52b74\PhpParser\Node\Expr\MethodCall($new, $staticCallToMethodCall->getMethodName(), $staticCall->args);
    }
}
