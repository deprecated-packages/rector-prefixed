<?php

declare (strict_types=1);
namespace Rector\DowngradePhp70\Rector\New_;

use RectorPrefix20210425\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\Function_;
use PhpParser\Node\Stmt\Namespace_;
use Rector\Core\NodeAnalyzer\ClassAnalyzer;
use Rector\Core\Rector\AbstractRector;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Tests\DowngradePhp70\Rector\New_\DowngradeAnonymousClassRector\DowngradeAnonymousClassRectorTest
 */
final class DowngradeAnonymousClassRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     */
    private const CLASS_NAME = 'AnonymousFor_';
    /**
     * @var ClassAnalyzer
     */
    private $classAnalyzer;
    public function __construct(\Rector\Core\NodeAnalyzer\ClassAnalyzer $classAnalyzer)
    {
        $this->classAnalyzer = $classAnalyzer;
    }
    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes() : array
    {
        return [\PhpParser\Node\Expr\New_::class];
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove anonymous class', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run()
    {
        return new class {
            public function execute()
            {
            }
        };
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class Anonymous
{
    public function execute()
    {
    }
}
class SomeClass
{
    public function run()
    {
        return new Anonymous();
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @param New_ $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->classAnalyzer->isAnonymousClass($node->class)) {
            return null;
        }
        $classNode = $this->betterNodeFinder->findParentType($node, \PhpParser\Node\Stmt\Class_::class);
        if ($classNode instanceof \PhpParser\Node\Stmt\Class_) {
            return $this->processMoveAnonymousClassInClass($node, $classNode);
        }
        $functionNode = $this->betterNodeFinder->findParentType($node, \PhpParser\Node\Stmt\Function_::class);
        if ($functionNode instanceof \PhpParser\Node\Stmt\Function_) {
            return $this->processMoveAnonymousClassInFunction($node, $functionNode);
        }
        $statement = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CURRENT_STATEMENT);
        return $this->processMoveAnonymousClassInDirectCall($node, $statement);
    }
    private function getNamespacedClassName(string $namespace, string $className) : string
    {
        return $namespace === '' ? $className : $namespace . '\\' . $className;
    }
    private function getClassName(string $namespace, string $shortName) : string
    {
        $className = self::CLASS_NAME . $shortName;
        $namespacedClassName = $this->getNamespacedClassName($namespace, $className);
        $count = 0;
        while ($this->nodeRepository->findClass($namespacedClassName)) {
            $className .= ++$count;
            $namespacedClassName = $this->getNamespacedClassName($namespace, $className);
        }
        return \ucfirst($className);
    }
    private function processMoveAnonymousClassInClass(\PhpParser\Node\Expr\New_ $new, \PhpParser\Node\Stmt\Class_ $class) : ?\PhpParser\Node\Expr\New_
    {
        $namespacedClassName = $this->getName($class->namespacedName);
        /** @var Identifier $shortClassName */
        $shortClassName = $class->name;
        $shortClassName = (string) $this->getName($shortClassName);
        $namespace = $namespacedClassName === $shortClassName ? '' : \RectorPrefix20210425\Nette\Utils\Strings::substring($namespacedClassName, 0, -\strlen($shortClassName) - 1);
        $className = $this->getClassName($namespace, $shortClassName);
        return $this->processMove($new, $className, $class);
    }
    private function processMoveAnonymousClassInFunction(\PhpParser\Node\Expr\New_ $new, \PhpParser\Node\Stmt\Function_ $function) : ?\PhpParser\Node\Expr\New_
    {
        $namespacedFunctionName = (string) $this->getName($function);
        $shortFunctionName = (string) $this->getName($function->name);
        $namespace = $namespacedFunctionName === $shortFunctionName ? '' : \RectorPrefix20210425\Nette\Utils\Strings::substring($namespacedFunctionName, 0, -\strlen($shortFunctionName) - 1);
        $className = $this->getClassName($namespace, $shortFunctionName);
        return $this->processMove($new, $className, $function);
    }
    private function processMoveAnonymousClassInDirectCall(\PhpParser\Node\Expr\New_ $new, \PhpParser\Node\Stmt $stmt) : ?\PhpParser\Node\Expr\New_
    {
        $parent = $stmt->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        while ($parent instanceof \PhpParser\Node && !$parent instanceof \PhpParser\Node\Stmt\Namespace_) {
            $parent = $parent->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        }
        $namespace = $parent instanceof \PhpParser\Node\Stmt\Namespace_ ? (string) $this->getName($parent) : '';
        $suffix = $namespace === '' ? 'NotInfunctionNoNamespace' : 'NotInFunction';
        $className = $this->getClassName($namespace, $suffix);
        return $this->processMove($new, $className, $stmt);
    }
    private function processMove(\PhpParser\Node\Expr\New_ $new, string $className, \PhpParser\Node $node) : ?\PhpParser\Node\Expr\New_
    {
        if (!$new->class instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $class = new \PhpParser\Node\Stmt\Class_($className, ['flags' => $new->class->flags, 'extends' => $new->class->extends, 'implements' => $new->class->implements, 'stmts' => $new->class->stmts, 'attrGroups' => $new->class->attrGroups]);
        $this->addNodeBeforeNode($class, $node);
        return new \PhpParser\Node\Expr\New_(new \PhpParser\Node\Name($className), $new->args);
    }
}
