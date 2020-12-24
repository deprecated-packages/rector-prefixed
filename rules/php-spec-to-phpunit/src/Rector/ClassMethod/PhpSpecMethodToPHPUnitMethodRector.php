<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Identifier;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
/**
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class PhpSpecMethodToPHPUnitMethodRector extends \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var PhpSpecRenaming
     */
    private $phpSpecRenaming;
    /**
     * @var PHPUnitTypeDeclarationDecorator
     */
    private $phpUnitTypeDeclarationDecorator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\PHPUnitTypeDeclarationDecorator $phpUnitTypeDeclarationDecorator, \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming $phpSpecRenaming)
    {
        $this->phpSpecRenaming = $phpSpecRenaming;
        $this->phpUnitTypeDeclarationDecorator = $phpUnitTypeDeclarationDecorator;
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
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        if ($this->isName($node, 'letGo')) {
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::TEAR_DOWN);
            $this->makeProtected($node);
            $this->phpUnitTypeDeclarationDecorator->decorate($node);
        } elseif ($this->isName($node, 'let')) {
            $node->name = new \_PhpScoper0a6b37af0871\PhpParser\Node\Identifier(\_PhpScoper0a6b37af0871\Rector\Core\ValueObject\MethodName::SET_UP);
            $this->makeProtected($node);
            $this->phpUnitTypeDeclarationDecorator->decorate($node);
        } else {
            $this->processTestMethod($node);
        }
        return $node;
    }
    private function processTestMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        // special case, @see https://johannespichler.com/writing-custom-phpspec-matchers/
        if ($this->isName($classMethod, 'getMatchers')) {
            return;
        }
        // change name to phpunit test case format
        $this->phpSpecRenaming->renameMethod($classMethod);
        // reorder instantiation + expected exception
        $previousStmt = null;
        foreach ((array) $classMethod->stmts as $key => $stmt) {
            if ($previousStmt && \_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($this->print($stmt), 'duringInstantiation') && \_PhpScoper0a6b37af0871\Nette\Utils\Strings::contains($this->print($previousStmt), 'beConstructedThrough')) {
                $classMethod->stmts[$key - 1] = $stmt;
                $classMethod->stmts[$key] = $previousStmt;
            }
            $previousStmt = $stmt;
        }
    }
}
