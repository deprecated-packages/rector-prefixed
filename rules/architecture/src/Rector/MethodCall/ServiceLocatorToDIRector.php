<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Architecture\Rector\MethodCall;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall;
use _PhpScopere8e811afab72\PhpParser\Node\Name;
use _PhpScopere8e811afab72\PhpParser\Node\Scalar\String_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PHPStan\Type\ObjectType;
use _PhpScopere8e811afab72\Rector\Core\Exception\Bridge\RectorProviderException;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface;
use _PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DoctrineCodeQuality\Tests\Rector\DoctrineRepositoryAsService\DoctrineRepositoryAsServiceTest
 */
final class ServiceLocatorToDIRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var DoctrineEntityAndRepositoryMapperInterface
     */
    private $doctrineEntityAndRepositoryMapper;
    /**
     * @var PropertyNaming
     */
    private $propertyNaming;
    public function __construct(\_PhpScopere8e811afab72\Rector\Doctrine\Contract\Mapper\DoctrineEntityAndRepositoryMapperInterface $doctrineEntityAndRepositoryMapper, \_PhpScopere8e811afab72\Rector\Naming\Naming\PropertyNaming $propertyNaming)
    {
        $this->doctrineEntityAndRepositoryMapper = $doctrineEntityAndRepositoryMapper;
        $this->propertyNaming = $propertyNaming;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns $this->getRepository() in Symfony Controller to constructor injection and private property access.', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
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
        return [\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall::class];
    }
    /**
     * @param MethodCall $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        if (!$this->isName($node->name, 'getRepository')) {
            return null;
        }
        $firstArgumentValue = $node->args[0]->value;
        // possible mocking → skip
        if ($firstArgumentValue instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\StaticCall) {
            return null;
        }
        /** @var string|null $className */
        $className = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if ($className === null) {
            return null;
        }
        /** @var MethodCall $methodCallNode */
        $methodCallNode = $node;
        if (\count((array) $methodCallNode->args) !== 1) {
            return null;
        }
        if ($methodCallNode->args[0]->value instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            /** @var String_ $string */
            $string = $methodCallNode->args[0]->value;
            // is alias
            if (\_PhpScopere8e811afab72\Nette\Utils\Strings::contains($string->value, ':')) {
                return null;
            }
        }
        if (\_PhpScopere8e811afab72\Nette\Utils\Strings::endsWith($className, 'Repository')) {
            return null;
        }
        $repositoryFqn = $this->resolveRepositoryFqnFromGetRepositoryMethodCall($node);
        $classLike = $node->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NODE);
        if (!$classLike instanceof \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_) {
            return null;
        }
        $repositoryObjectType = new \_PhpScopere8e811afab72\PHPStan\Type\ObjectType($repositoryFqn);
        $this->addConstructorDependencyToClass($classLike, $repositoryObjectType, $this->propertyNaming->fqnToVariableName($repositoryObjectType));
        return $this->createPropertyFetch('this', $this->propertyNaming->fqnToVariableName($repositoryObjectType));
    }
    private function resolveRepositoryFqnFromGetRepositoryMethodCall(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $entityFqnOrAlias = $this->entityFqnOrAlias($methodCall);
        if ($entityFqnOrAlias !== null) {
            $repositoryClassName = $this->doctrineEntityAndRepositoryMapper->mapEntityToRepository($entityFqnOrAlias);
            if ($repositoryClassName !== null) {
                return $repositoryClassName;
            }
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\Bridge\RectorProviderException(\sprintf('A repository was not provided for "%s" entity by your "%s" class.', $entityFqnOrAlias, \get_class($this->doctrineEntityAndRepositoryMapper)));
    }
    private function entityFqnOrAlias(\_PhpScopere8e811afab72\PhpParser\Node\Expr\MethodCall $methodCall) : string
    {
        $repositoryArgument = $methodCall->args[0]->value;
        if ($repositoryArgument instanceof \_PhpScopere8e811afab72\PhpParser\Node\Scalar\String_) {
            return $repositoryArgument->value;
        }
        if ($repositoryArgument instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\ClassConstFetch && $repositoryArgument->class instanceof \_PhpScopere8e811afab72\PhpParser\Node\Name) {
            return $this->getName($repositoryArgument->class);
        }
        throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException('Unable to resolve repository argument');
    }
}
