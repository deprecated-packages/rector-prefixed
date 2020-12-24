<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\Doctrine\Rector\MethodCall;

use _PhpScoper2a4e7ab1ecbc\Doctrine\Common\Persistence\ManagerRegistry as DeprecatedManagerRegistry;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Common\Persistence\ObjectManager as DeprecatedObjectManager;
use _PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityManagerInterface;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Persistence\ManagerRegistry;
use _PhpScoper2a4e7ab1ecbc\Doctrine\Persistence\ObjectManager;
use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use _PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\Doctrine\Tests\Rector\MethodCall\EntityAliasToClassConstantReferenceRector\EntityAliasToClassConstantReferenceRectorTest
 */
final class EntityAliasToClassConstantReferenceRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector implements \_PhpScoper2a4e7ab1ecbc\Rector\Core\Contract\Rector\ConfigurableRectorInterface
{
    /**
     * @api
     * @var string
     */
    public const ALIASES_TO_NAMESPACES = '$aliasesToNamespaces';
    /**
     * @var string[]
     */
    private const ALLOWED_OBJECT_TYPES = [\_PhpScoper2a4e7ab1ecbc\Doctrine\ORM\EntityManagerInterface::class, \_PhpScoper2a4e7ab1ecbc\Doctrine\Persistence\ObjectManager::class, \_PhpScoper2a4e7ab1ecbc\Doctrine\Common\Persistence\ObjectManager::class, \_PhpScoper2a4e7ab1ecbc\Doctrine\Persistence\ManagerRegistry::class, \_PhpScoper2a4e7ab1ecbc\Doctrine\Common\Persistence\ManagerRegistry::class];
    /**
     * @var string[]
     */
    private $aliasesToNamespaces = [];
    public function getRuleDefinition() : \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Replaces doctrine alias with class.', [new \_PhpScoper2a4e7ab1ecbc\Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
$entityManager = new Doctrine\ORM\EntityManager();
$entityManager->getRepository("AppBundle:Post");
CODE_SAMPLE
, <<<'CODE_SAMPLE'
$entityManager = new Doctrine\ORM\EntityManager();
$entityManager->getRepository(\App\Entity\Post::class);
CODE_SAMPLE
, [self::ALIASES_TO_NAMESPACES => ['App' => '_PhpScoper2a4e7ab1ecbc\\App\\Entity']])]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\PhpParser\Node
    {
        if (!$this->isObjectTypes($node->var, self::ALLOWED_OBJECT_TYPES)) {
            return null;
        }
        if (!$this->isName($node->name, 'getRepository')) {
            return null;
        }
        if (!isset($node->args[0])) {
            return null;
        }
        if (!$node->args[0]->value instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
            return null;
        }
        /** @var String_ $stringNode */
        $stringNode = $node->args[0]->value;
        if (!$this->isAliasWithConfiguredEntity($stringNode->value)) {
            return null;
        }
        $node->args[0]->value = $this->createClassConstantReference($this->convertAliasToFqn($node->args[0]->value->value));
        return $node;
    }
    public function configure(array $configuration) : void
    {
        $this->aliasesToNamespaces = $configuration[self::ALIASES_TO_NAMESPACES] ?? [];
    }
    private function isAliasWithConfiguredEntity(string $name) : bool
    {
        if (!$this->isAlias($name)) {
            return \false;
        }
        return $this->hasAlias($name);
    }
    private function convertAliasToFqn(string $name) : string
    {
        [$namespaceAlias, $simpleClassName] = \explode(':', $name, 2);
        return \sprintf('%s\\%s', $this->aliasesToNamespaces[$namespaceAlias], $simpleClassName);
    }
    private function isAlias(string $name) : bool
    {
        return \_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($name, ':');
    }
    private function hasAlias(string $name) : bool
    {
        return isset($this->aliasesToNamespaces[\strtok($name, ':')]);
    }
}
