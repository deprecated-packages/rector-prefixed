<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\Class_;

use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Name;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\LetManipulator;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming;
use _PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector;
use _PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory;
/**
 * @see \Rector\PhpSpecToPHPUnit\Tests\Rector\Variable\PhpSpecToPHPUnitRector\PhpSpecToPHPUnitRectorTest
 */
final class PhpSpecClassToPHPUnitClassRector extends \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Rector\AbstractPhpSpecToPHPUnitRector
{
    /**
     * @var ObjectType
     */
    private $testedObjectType;
    /**
     * @var PhpSpecRenaming
     */
    private $phpSpecRenaming;
    /**
     * @var LetManipulator
     */
    private $letManipulator;
    /**
     * @var ClassInsertManipulator
     */
    private $classInsertManipulator;
    /**
     * @var SetUpClassMethodFactory
     */
    private $setUpClassMethodFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\Core\PhpParser\Node\Manipulator\ClassInsertManipulator $classInsertManipulator, \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\LetManipulator $letManipulator, \_PhpScoper0a6b37af0871\Rector\PhpSpecToPHPUnit\Naming\PhpSpecRenaming $phpSpecRenaming, \_PhpScoper0a6b37af0871\Rector\PHPUnit\NodeFactory\SetUpClassMethodFactory $setUpClassMethodFactory)
    {
        $this->phpSpecRenaming = $phpSpecRenaming;
        $this->letManipulator = $letManipulator;
        $this->classInsertManipulator = $classInsertManipulator;
        $this->setUpClassMethodFactory = $setUpClassMethodFactory;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_::class];
    }
    /**
     * @param Class_ $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!$this->isInPhpSpecBehavior($node)) {
            return null;
        }
        // 1. change namespace name to PHPUnit-like
        $this->phpSpecRenaming->renameNamespace($node);
        $propertyName = $this->phpSpecRenaming->resolveObjectPropertyName($node);
        $this->phpSpecRenaming->renameClass($node);
        $this->phpSpecRenaming->renameExtends($node);
        $testedClass = $this->phpSpecRenaming->resolveTestedClass($node);
        $this->testedObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType($testedClass);
        $this->classInsertManipulator->addPropertyToClass($node, $propertyName, $this->testedObjectType);
        $classMethod = $node->getMethod('let');
        // add let if missing
        if ($classMethod === null) {
            if (!$this->letManipulator->isLetNeededInClass($node)) {
                return null;
            }
            $letClassMethod = $this->createLetClassMethod($propertyName);
            $this->classInsertManipulator->addAsFirstMethod($node, $letClassMethod);
        }
        return $this->removeSelfTypeMethod($node);
    }
    private function createLetClassMethod(string $propertyName) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $propertyFetch = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\PropertyFetch(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable('this'), $propertyName);
        $testedObjectType = $this->staticTypeMapper->mapPHPStanTypeToPhpParserNode($this->testedObjectType);
        if (!$testedObjectType instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Name) {
            throw new \_PhpScoper0a6b37af0871\Rector\Core\Exception\ShouldNotHappenException();
        }
        $new = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\New_($testedObjectType);
        $assign = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign($propertyFetch, $new);
        return $this->setUpClassMethodFactory->createSetUpMethod([$assign]);
    }
    /**
     * This is already checked on construction of object
     */
    private function removeSelfTypeMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_
    {
        foreach ($class->getMethods() as $classMethod) {
            $classMethodStmts = (array) $classMethod->stmts;
            if (\count($classMethodStmts) !== 1) {
                continue;
            }
            $innerClassMethodStmt = $this->resolveFirstNonExpressionStmt($classMethodStmts);
            if (!$innerClassMethodStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall) {
                continue;
            }
            if (!$this->isName($innerClassMethodStmt->name, 'shouldHaveType')) {
                continue;
            }
            // not the tested type
            if (!$this->isValue($innerClassMethodStmt->args[0]->value, $this->testedObjectType->getClassName())) {
                continue;
            }
            // remove it
            $this->removeNodeFromStatements($class, $classMethod);
        }
        return $class;
    }
    /**
     * @param Stmt[] $stmts
     */
    private function resolveFirstNonExpressionStmt(array $stmts) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if (!isset($stmts[0])) {
            return null;
        }
        $firstStmt = $stmts[0];
        if ($firstStmt instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression) {
            return $firstStmt->expr;
        }
        return $firstStmt;
    }
}
