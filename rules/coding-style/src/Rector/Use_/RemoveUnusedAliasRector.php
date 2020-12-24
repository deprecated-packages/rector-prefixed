<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\CodingStyle\Rector\Use_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Param;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse;
use _PhpScopere8e811afab72\Rector\CodingStyle\Naming\NameRenamer;
use _PhpScopere8e811afab72\Rector\CodingStyle\Node\DocAliasResolver;
use _PhpScopere8e811afab72\Rector\CodingStyle\Node\UseManipulator;
use _PhpScopere8e811afab72\Rector\CodingStyle\Node\UseNameAliasToNameResolver;
use _PhpScopere8e811afab72\Rector\CodingStyle\ValueObject\NameAndParent;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\CodingStyle\Tests\Rector\Use_\RemoveUnusedAliasRector\RemoveUnusedAliasRectorTest
 */
final class RemoveUnusedAliasRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var NameAndParent[][]
     */
    private $resolvedNodeNames = [];
    /**
     * @var array<string, string[]>
     */
    private $useNamesAliasToName = [];
    /**
     * @var string[]
     */
    private $resolvedDocPossibleAliases = [];
    /**
     * @var DocAliasResolver
     */
    private $docAliasResolver;
    /**
     * @var UseNameAliasToNameResolver
     */
    private $useNameAliasToNameResolver;
    /**
     * @var UseManipulator
     */
    private $useManipulator;
    /**
     * @var NameRenamer
     */
    private $nameRenamer;
    public function __construct(\_PhpScopere8e811afab72\Rector\CodingStyle\Node\DocAliasResolver $docAliasResolver, \_PhpScopere8e811afab72\Rector\CodingStyle\Node\UseManipulator $useManipulator, \_PhpScopere8e811afab72\Rector\CodingStyle\Node\UseNameAliasToNameResolver $useNameAliasToNameResolver, \_PhpScopere8e811afab72\Rector\CodingStyle\Naming\NameRenamer $nameRenamer)
    {
        $this->docAliasResolver = $docAliasResolver;
        $this->useNameAliasToNameResolver = $useNameAliasToNameResolver;
        $this->useManipulator = $useManipulator;
        $this->nameRenamer = $nameRenamer;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Removes unused use aliases. Keep annotation aliases like "Doctrine\\ORM\\Mapping as ORM" to keep convention format', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Symfony\Kernel as BaseKernel;

class SomeClass extends BaseKernel
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Symfony\Kernel;

class SomeClass extends Kernel
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_::class];
    }
    /**
     * @param Use_ $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if ($this->shouldSkipUse($node)) {
            return null;
        }
        $searchNode = $this->resolveSearchNode($node);
        if ($searchNode === null) {
            return null;
        }
        $this->resolvedNodeNames = $this->useManipulator->resolveUsedNameNodes($searchNode);
        $this->resolvedDocPossibleAliases = $this->docAliasResolver->resolve($searchNode);
        $this->useNamesAliasToName = $this->useNameAliasToNameResolver->resolve($node);
        // lowercase
        $this->resolvedDocPossibleAliases = $this->lowercaseArray($this->resolvedDocPossibleAliases);
        $this->resolvedNodeNames = \array_change_key_case($this->resolvedNodeNames, \CASE_LOWER);
        $this->useNamesAliasToName = \array_change_key_case($this->useNamesAliasToName, \CASE_LOWER);
        foreach ($node->uses as $use) {
            if ($use->alias === null) {
                continue;
            }
            $lastName = $use->name->getLast();
            $lowercasedLastName = \strtolower($lastName);
            /** @var string $aliasName */
            $aliasName = $this->getName($use->alias);
            if ($this->shouldSkip($lastName, $aliasName)) {
                continue;
            }
            // only last name is used → no need for alias
            if (isset($this->resolvedNodeNames[$lowercasedLastName])) {
                $use->alias = null;
                continue;
            }
            $this->refactorAliasName($aliasName, $lastName, $use);
        }
        return $node;
    }
    private function shouldSkipUse(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : bool
    {
        // skip cases without namespace, problematic to analyse
        $namespace = $use->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NODE);
        if ($namespace === null) {
            return \true;
        }
        return !$this->hasUseAlias($use);
    }
    private function resolveSearchNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        $searchNode = $use->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::PARENT_NODE);
        if ($searchNode !== null) {
            return $searchNode;
        }
        return $use->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NEXT_NODE);
    }
    /**
     * @param string[] $values
     * @return string[]
     */
    private function lowercaseArray(array $values) : array
    {
        return \array_map(function (string $value) : string {
            return \strtolower($value);
        }, $values);
    }
    private function shouldSkip(string $lastName, string $aliasName) : bool
    {
        // PHP is case insensitive
        $loweredLastName = \strtolower($lastName);
        $loweredAliasName = \strtolower($aliasName);
        // both are used → nothing to remove
        if (isset($this->resolvedNodeNames[$loweredLastName], $this->resolvedNodeNames[$loweredAliasName])) {
            return \true;
        }
        // part of some @Doc annotation
        return \in_array($loweredAliasName, $this->resolvedDocPossibleAliases, \true);
    }
    private function refactorAliasName(string $aliasName, string $lastName, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\UseUse $useUse) : void
    {
        // only alias name is used → use last name directly
        $lowerAliasName = \strtolower($aliasName);
        if (!isset($this->resolvedNodeNames[$lowerAliasName])) {
            return;
        }
        // keep to differentiate 2 aliases classes
        $lowerLastName = \strtolower($lastName);
        if (\count($this->useNamesAliasToName[$lowerLastName] ?? []) > 1) {
            return;
        }
        $this->nameRenamer->renameNameNode($this->resolvedNodeNames[$lowerAliasName], $lastName);
        $useUse->alias = null;
    }
    private function hasUseAlias(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Use_ $use) : bool
    {
        foreach ($use->uses as $useUse) {
            if ($useUse->alias !== null) {
                return \true;
            }
        }
        return \false;
    }
}
