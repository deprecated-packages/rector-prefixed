<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\CakePHP\Rector\Namespace_;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Declare_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Use_;
use _PhpScoper0a2ac50786fa\Rector\CakePHP\Naming\CakePHPFullyQualifiedClassNameResolver;
use _PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://github.com/cakephp/upgrade/blob/756410c8b7d5aff9daec3fa1fe750a3858d422ac/src/Shell/Task/AppUsesTask.php
 * @see https://github.com/cakephp/upgrade/search?q=uses&unscoped_q=uses
 *
 * @see \Rector\CakePHP\Tests\Rector\Namespace_\AppUsesStaticCallToUseStatementRector\AppUsesStaticCallToUseStatementRectorTest
 */
final class AppUsesStaticCallToUseStatementRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    /**
     * @var CakePHPFullyQualifiedClassNameResolver
     */
    private $cakePHPFullyQualifiedClassNameResolver;
    public function __construct(\_PhpScoper0a2ac50786fa\Rector\CakePHP\Naming\CakePHPFullyQualifiedClassNameResolver $cakePHPFullyQualifiedClassNameResolver)
    {
        $this->cakePHPFullyQualifiedClassNameResolver = $cakePHPFullyQualifiedClassNameResolver;
    }
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change App::uses() to use imports', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
App::uses('NotificationListener', 'Event');

CakeEventManager::instance()->attach(new NotificationListener());
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Event\NotificationListener;

CakeEventManager::instance()->attach(new NotificationListener());
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace::class, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param FileWithoutNamespace|Namespace_ $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
    {
        $appUsesStaticCalls = $this->collectAppUseStaticCalls($node);
        if ($appUsesStaticCalls === []) {
            return null;
        }
        $this->removeNodes($appUsesStaticCalls);
        $names = $this->resolveNamesFromStaticCalls($appUsesStaticCalls);
        $uses = $this->nodeFactory->createUsesFromNames($names);
        if ($node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_) {
            $node->stmts = \array_merge($uses, (array) $node->stmts);
            return $node;
        }
        return $this->refactorFile($node, $uses);
    }
    /**
     * @return StaticCall[]
     */
    private function collectAppUseStaticCalls(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : array
    {
        /** @var StaticCall[] $appUsesStaticCalls */
        $appUsesStaticCalls = $this->betterNodeFinder->find($node, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->isStaticCallNamed($node, 'App', 'uses');
        });
        return $appUsesStaticCalls;
    }
    /**
     * @param StaticCall[] $staticCalls
     * @return string[]
     */
    private function resolveNamesFromStaticCalls(array $staticCalls) : array
    {
        $names = [];
        foreach ($staticCalls as $staticCall) {
            $names[] = $this->createFullyQualifiedNameFromAppUsesStaticCall($staticCall);
        }
        return $names;
    }
    /**
     * @param Use_[] $uses
     */
    private function refactorFile(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace $fileWithoutNamespace, array $uses) : ?\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace
    {
        $hasNamespace = $this->betterNodeFinder->findFirstInstanceOf($fileWithoutNamespace, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Namespace_::class);
        // already handled above
        if ($hasNamespace !== null) {
            return null;
        }
        $hasDeclare = $this->betterNodeFinder->findFirstInstanceOf($fileWithoutNamespace, \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Declare_::class);
        if ($hasDeclare !== null) {
            return $this->refactorFileWithDeclare($fileWithoutNamespace, $uses);
        }
        $fileWithoutNamespace->stmts = \array_merge($uses, (array) $fileWithoutNamespace->stmts);
        return $fileWithoutNamespace;
    }
    private function createFullyQualifiedNameFromAppUsesStaticCall(\_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\StaticCall $staticCall) : string
    {
        /** @var string $shortClassName */
        $shortClassName = $this->getValue($staticCall->args[0]->value);
        /** @var string $namespaceName */
        $namespaceName = $this->getValue($staticCall->args[1]->value);
        return $this->cakePHPFullyQualifiedClassNameResolver->resolveFromPseudoNamespaceAndShortClassName($namespaceName, $shortClassName);
    }
    /**
     * @param Use_[] $uses
     */
    private function refactorFileWithDeclare(\_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace $fileWithoutNamespace, array $uses) : \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace
    {
        $newStmts = [];
        foreach ($fileWithoutNamespace->stmts as $stmt) {
            $newStmts[] = $stmt;
            if ($stmt instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Declare_) {
                foreach ($uses as $use) {
                    $newStmts[] = $use;
                }
                continue;
            }
        }
        return new \_PhpScoper0a2ac50786fa\Rector\Core\PhpParser\Node\CustomNode\FileWithoutNamespace($newStmts);
    }
}
