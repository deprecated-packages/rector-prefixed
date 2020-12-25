<?php

declare (strict_types=1);
namespace Rector\Doctrine\Rector\ClassMethod;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface;
use Rector\Core\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @sponsor Thanks https://spaceflow.io/ for sponsoring this rule - visit them on https://github.com/SpaceFlow-app
 *
 * @see \Rector\Doctrine\Tests\Rector\ClassMethod\ChangeSetIdTypeToUuidRector\ChangeSetIdTypeToUuidRectorTest
 */
final class ChangeSetIdTypeToUuidRector extends \Rector\Core\Rector\AbstractRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change param type of setId() to uuid interface', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
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
            if ($currentType === \_PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface::class) {
                return null;
            }
        }
        $node->params[0]->type = new \PhpParser\Node\Name\FullyQualified(\_PhpScoper50d83356d739\Ramsey\Uuid\UuidInterface::class);
        return $node;
    }
    private function renameUuidVariableToId(\PhpParser\Node\Stmt\ClassMethod $classMethod) : void
    {
        $this->traverseNodesWithCallable($classMethod, function (\PhpParser\Node $node) : ?Identifier {
            if (!$node instanceof \PhpParser\Node\Identifier) {
                return null;
            }
            if (!$this->isName($node, 'uuid')) {
                return null;
            }
            return new \PhpParser\Node\Identifier('id');
        });
    }
}
