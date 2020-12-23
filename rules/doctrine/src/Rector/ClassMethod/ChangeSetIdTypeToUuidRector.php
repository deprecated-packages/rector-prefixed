<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Doctrine\Rector\ClassMethod;

use _PhpScoper0a2ac50786fa\PhpParser\Node;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Identifier;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface;
use _PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ChangeSetIdTypeToUuidRector\ChangeSetIdTypeToUuidRectorTest
 */
final class ChangeSetIdTypeToUuidRector extends \_PhpScoper0a2ac50786fa\Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type of setId() to uuid interface', [new \_PhpScoper0a2ac50786fa\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?\_PhpScoper0a2ac50786fa\PhpParser\Node
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
            if ($currentType === \_PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface::class) {
                return null;
            }
        }
        $node->params[0]->type = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Name\FullyQualified(\_PhpScoper0a2ac50786fa\Ramsey\Uuid\UuidInterface::class);
        return $node;
    }
    private function renameUuidVariableToId(\_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable($classMethod, function (\_PhpScoper0a2ac50786fa\PhpParser\Node $node) : ?Identifier {
            if (!$node instanceof \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier) {
                return null;
            }
            if (!$this->isName($node, 'uuid')) {
                return null;
            }
            return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Identifier('id');
        });
    }
}
