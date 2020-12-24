<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Doctrine\Rector\ClassMethod;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Identifier;
use _PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ChangeSetIdTypeToUuidRector\ChangeSetIdTypeToUuidRectorTest
 */
final class ChangeSetIdTypeToUuidRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type of setId() to uuid interface', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SetId
{
    private $id;

    public function setId(int $uuid): int
    {
        return $this->id = $uuid;
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class SetId
{
    private $id;

    public function setId(\Ramsey\Uuid\UuidInterface $uuid): int
    {
        return $this->id = $uuid;
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isInDoctrineEntityClass($node)) {
            return null;
        }
        if (!$this->isName($node, 'setId')) {
            return null;
        }
        $this->renameUuidVariableToId($node);
        // is already set?
        if ($node->params[0]->type !== null) {
            $currentType = $this->getName($node->params[0]->type);
            if ($currentType === \_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface::class) {
                return null;
            }
        }
        $node->params[0]->type = new \_PhpScopere8e811afab72\PhpParser\Node\Name\FullyQualified(\_PhpScopere8e811afab72\Ramsey\Uuid\UuidInterface::class);
        return $node;
    }
    private function renameUuidVariableToId(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable($classMethod, function (\_PhpScopere8e811afab72\PhpParser\Node $node) : ?Identifier {
            if (!$node instanceof \_PhpScopere8e811afab72\PhpParser\Node\Identifier) {
                return null;
            }
            if (!$this->isName($node, 'uuid')) {
                return null;
            }
            return new \_PhpScopere8e811afab72\PhpParser\Node\Identifier('id');
        });
    }
}
