<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Restoration\Rector\Namespace_;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\UseBuilder;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Restoration\Tests\Rector\Namespace_\CompleteImportForPartialAnnotationRector\CompleteImportForPartialAnnotationRectorTest
 */
final class CompleteImportForPartialAnnotationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector implements \_PhpScopere8e811afab72\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const USE_IMPORTS_TO_RESTORE = '$useImportsToRestore';
    /**
     * @var UseWithAlias[]
     */
    private $useImportsToRestore = [];
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('In case you have accidentally removed use imports but code still contains partial use statements, this will save you', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    /**
     * @ORM\Id
     */
    public $id;
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

class SomeClass
{
    /**
     * @ORM\Id
     */
    public $id;
}
CODE_SAMPLE
, [self::USE_IMPORTS_TO_RESTORE => [new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias('_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping', 'ORM')]])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_::class];
    }
    /**
     * @param Namespace_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        /** @var Class_|null $class */
        $class = $this->betterNodeFinder->findFirstInstanceOf((array) $node->stmts, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class);
        if ($class === null) {
            return null;
        }
        foreach ($this->useImportsToRestore as $useImportToRestore) {
            $annotationToSeek = '#\\*\\s+\\@' . $useImportToRestore->getAlias() . '#';
            if (!\_PhpScopere8e811afab72\Nette\Utils\Strings::match($this->print($class), $annotationToSeek)) {
                continue;
            }
            $node = $this->addImportToNamespaceIfMissing($node, $useImportToRestore);
        }
        return $node;
    }
    /**
     * @param UseWithAlias[][] $configuration
     */
    public function configure(array $configuration) : void
    {
        $default = [new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias('_PhpScopere8e811afab72\\Doctrine\\ORM\\Mapping', 'ORM'), new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias('_PhpScopere8e811afab72\\Symfony\\Component\\Validator\\Constraints', 'Assert'), new \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias('_PhpScopere8e811afab72\\JMS\\Serializer\\Annotation', 'Serializer')];
        $this->useImportsToRestore = \array_merge($configuration[self::USE_IMPORTS_TO_RESTORE] ?? [], $default);
    }
    private function addImportToNamespaceIfMissing(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias $useWithAlias) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        foreach ($namespace->stmts as $stmt) {
            if (!$stmt instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_) {
                continue;
            }
            $useUse = $stmt->uses[0];
            // already there
            if ($this->isName($useUse->name, $useWithAlias->getUse()) && (string) $useUse->alias === $useWithAlias->getAlias()) {
                return $namespace;
            }
        }
        return $this->addImportToNamespace($namespace, $useWithAlias);
    }
    private function addImportToNamespace(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, \_PhpScopere8e811afab72\Rector\Restoration\ValueObject\UseWithAlias $useWithAlias) : \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_
    {
        $useBuilder = new \_PhpScopere8e811afab72\Rector\Core\PhpParser\Builder\UseBuilder($useWithAlias->getUse());
        if ($useWithAlias->getAlias() !== '') {
            $useBuilder->as($useWithAlias->getAlias());
        }
        /** @var Stmt $use */
        $use = $useBuilder->getNode();
        $namespace->stmts = \array_merge([$use], (array) $namespace->stmts);
        return $namespace;
    }
}
