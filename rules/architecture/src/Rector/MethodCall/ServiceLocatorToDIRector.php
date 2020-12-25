<?php

declare (strict_types=1);
namespace Rector\Architecture\Rector\MethodCall;

use _PhpScoper17db12703726\Nette\Utils\Strings;
use PhpParser\Node;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Name;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Stmt\Class_;
use PHPStan\Type\ObjectType;
use Rector\Core\Exception\Bridge\RectorProviderException;
use Rector\Core\Exception\ShouldNotHappenException;
use Rector\Core\Rector\AbstractRector;
use Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use Rector\Naming\Naming\PropertyNaming;
use Rector\NodeTypeResolver\Node\AttributeKey;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class ServiceLocatorToDIRector extends \Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityAndRepositoryMapperInterface
     */
    private $doctrineEntityAndRepositoryMapper;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface $doctrineEntityAndRepositoryMapper, \Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->doctrineEntityAndRepositoryMapper = $doctrineEntityAndRepositoryMapper;
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns $this->getRepository() in Symfony Controller to constructor injection and private property access.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
class ProductController extends Controller
{
    public function someAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->getRepository('SomethingBundle:Product')->findSomething(...);
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function someAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $this->productRepository->findSomething(...);
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
        return [\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\PhpParser\Node $node) : ?\PhpParser\Node
    {
        if (!$this->isName($node->name, 'getRepository')) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        // possible mocking → skip
        if ($firstArgumentValue instanceof \PhpParser\Node\Expr\StaticCall) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        /** @var MethodCall $methodCallNode */
        $methodCallNode = $node;
        if (\count($methodCallNode->args) !== 1) {
            return null;
        }
        if ($methodCallNode->args[0]->value instanceof \PhpParser\Node\Scalar\String_) {
            /** @var String_ $string */
            $string = $methodCallNode->args[0]->value;
            // is alias
            if (\_PhpScoper17db12703726\Nette\Utils\Strings::contains($string->value, ':')) {
                return null;
            }
        }
        if (\_PhpScoper17db12703726\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        $repositoryFqn = $this->resolveRepositoryFqnFromGetRepositoryMethodCall($node);
        $classLike = $node->getAttribute(\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $repositoryObjectType = new \PHPStan\Type\ObjectType($repositoryFqn);
        $this->addConstructorDependencyToClass($classLike, $repositoryObjectType, $this->propertyNaming->fqnToVariableName($repositoryObjectType));
        return $this->createPropertyFetch('this', $this->propertyNaming->fqnToVariableName($repositoryObjectType));
    }
    private function resolveRepositoryFqnFromGetRepositoryMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $entityFqnOrAlias = $this->entityFqnOrAlias($methodCall);
        if ($entityFqnOrAlias !== null) {
            $repositoryClassName = $this->doctrineEntityAndRepositoryMapper->mapEntityToRepository($entityFqnOrAlias);
            if ($repositoryClassName !== null) {
                return $repositoryClassName;
            }
        }
        throw new \Rector\Core\Exception\Bridge\RectorProviderException(\sprintf('A repository was not provided for "%s" entity by your "%s" class.', $entityFqnOrAlias, \get_class($this->doctrineEntityAndRepositoryMapper)));
    }
    private function entityFqnOrAlias(\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $repositoryArgument = $methodCall->args[0]->value;
        if ($repositoryArgument instanceof \PhpParser\Node\Scalar\String_) {
            return $repositoryArgument->value;
        }
        if ($repositoryArgument instanceof \PhpParser\Node\Expr\ClassConstFetch && $repositoryArgument->class instanceof \PhpParser\Node\Name) {
            return $this->getName($repositoryArgument->class);
        }
        throw new \Rector\Core\Exception\ShouldNotHappenException('Unable to resolve repository argument');
    }
}
