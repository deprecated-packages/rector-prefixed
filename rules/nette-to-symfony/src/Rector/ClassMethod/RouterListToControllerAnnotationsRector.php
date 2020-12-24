<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Rector\ClassMethod;

use _PhpScoper0a6b37af0871\Nette\Application\Routers\RouteList;
use _PhpScoper0a6b37af0871\Nette\Utils\Strings;
use _PhpScoper0a6b37af0871\PhpParser\Node;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper0a6b37af0871\PHPStan\Type\ObjectType;
use _PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode;
use _PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector;
use _PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Route\RouteInfoFactory;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\Routing\ExplicitRouteAnnotationDecorator;
use _PhpScoper0a6b37af0871\Rector\NetteToSymfony\ValueObject\RouteInfo;
use _PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer;
use ReflectionMethod;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://doc.nette.org/en/2.4/routing
 * @see https://symfony.com/doc/current/routing.html
 *
 * @see \Rector\NetteToSymfony\Tests\Rector\ClassMethod\RouterListToControllerAnnotationsRector\RouterListToControllerAnnotationsRectorTest
 */
final class RouterListToControllerAnnotationsRector extends \_PhpScoper0a6b37af0871\Rector\Core\Rector\AbstractRector
{
    /**
     * @var string
     * @see https://regex101.com/r/qVlXk2/2
     */
    private const ACTION_RENDER_NAME_MATCHING_REGEX = '#^(action|render)(?<short_action_name>.*?$)#sm';
    /**
     * @var RouteInfoFactory
     */
    private $routeInfoFactory;
    /**
     * @var ReturnTypeInferer
     */
    private $returnTypeInferer;
    /**
     * @var ExplicitRouteAnnotationDecorator
     */
    private $explicitRouteAnnotationDecorator;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Routing\ExplicitRouteAnnotationDecorator $explicitRouteAnnotationDecorator, \_PhpScoper0a6b37af0871\Rector\TypeDeclaration\TypeInferer\ReturnTypeInferer $returnTypeInferer, \_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Route\RouteInfoFactory $routeInfoFactory)
    {
        $this->routeInfoFactory = $routeInfoFactory;
        $this->returnTypeInferer = $returnTypeInferer;
        $this->explicitRouteAnnotationDecorator = $explicitRouteAnnotationDecorator;
    }
    public function getRuleDefinition() : \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change new Route() from RouteFactory to @Route annotation above controller method', [new \_PhpScoper0a6b37af0871\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
final class RouterFactory
{
    public function create(): RouteList
    {
        $routeList = new RouteList();
        $routeList[] = new Route('some-path', SomePresenter::class);

        return $routeList;
    }
}

final class SomePresenter
{
    public function run()
    {
    }
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
final class RouterFactory
{
    public function create(): RouteList
    {
        $routeList = new RouteList();

        // case of single action controller, usually get() or __invoke() method
        $routeList[] = new Route('some-path', SomePresenter::class);

        return $routeList;
    }
}

use Symfony\Component\Routing\Annotation\Route;

final class SomePresenter
{
    /**
     * @Route(path="some-path")
     */
    public function run()
    {
    }
}
CODE_SAMPLE
)]);
    }
    /**
     * List of nodes this class checks, classes that implement @see \PhpParser\Node
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod::class];
    }
    /**
     * @param ClassMethod $node
     */
    public function refactor(\_PhpScoper0a6b37af0871\PhpParser\Node $node) : ?\_PhpScoper0a6b37af0871\PhpParser\Node
    {
        if ($node->stmts === null || $node->stmts === []) {
            return null;
        }
        $inferedReturnType = $this->returnTypeInferer->inferFunctionLike($node);
        $routeListObjectType = new \_PhpScoper0a6b37af0871\PHPStan\Type\ObjectType(\_PhpScoper0a6b37af0871\Nette\Application\Routers\RouteList::class);
        if (!$inferedReturnType->isSuperTypeOf($routeListObjectType)->yes()) {
            return null;
        }
        $assignNodes = $this->resolveAssignRouteNodes($node);
        if ($assignNodes === []) {
            return null;
        }
        $routeInfos = $this->createRouteInfosFromAssignNodes($assignNodes);
        /** @var RouteInfo $routeInfo */
        foreach ($routeInfos as $routeInfo) {
            $classMethod = $this->resolveControllerClassMethod($routeInfo);
            if ($classMethod === null) {
                continue;
            }
            $symfonyRoutePhpDocTagValueNode = $this->createSymfonyRoutePhpDocTagValueNode($routeInfo);
            $this->explicitRouteAnnotationDecorator->decorateClassMethodWithRouteAnnotation($classMethod, $symfonyRoutePhpDocTagValueNode);
        }
        // complete all other non-explicit methods, from "<presenter>/<action>"
        $this->completeImplicitRoutes();
        // remove routes
        $this->removeNodes($assignNodes);
        return null;
    }
    /**
     * @return Assign[]
     */
    private function resolveAssignRouteNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : array
    {
        // look for <...>[] = IRoute<Type>
        return $this->betterNodeFinder->find((array) $classMethod->stmts, function (\_PhpScoper0a6b37af0871\PhpParser\Node $node) : bool {
            if (!$node instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Assign) {
                return \false;
            }
            // $routeList[] =
            if (!$node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\ArrayDimFetch) {
                return \false;
            }
            if ($this->isObjectType($node->expr, '_PhpScoper0a6b37af0871\\Nette\\Application\\IRouter')) {
                return \true;
            }
            if ($node->expr instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall) {
                // for custom static route factories
                return $this->isRouteStaticCallMatch($node->expr);
            }
            return \false;
        });
    }
    /**
     * @param Assign[] $assignNodes
     * @return RouteInfo[]
     */
    private function createRouteInfosFromAssignNodes(array $assignNodes) : array
    {
        $routeInfos = [];
        // collect annotations and target controllers
        foreach ($assignNodes as $assignNode) {
            $routeNameToControllerMethod = $this->routeInfoFactory->createFromNode($assignNode->expr);
            if ($routeNameToControllerMethod === null) {
                continue;
            }
            $routeInfos[] = $routeNameToControllerMethod;
        }
        return $routeInfos;
    }
    private function resolveControllerClassMethod(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\ValueObject\RouteInfo $routeInfo) : ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod
    {
        $classNode = $this->nodeRepository->findClass($routeInfo->getClass());
        if ($classNode === null) {
            return null;
        }
        return $classNode->getMethod($routeInfo->getMethod());
    }
    private function createSymfonyRoutePhpDocTagValueNode(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\ValueObject\RouteInfo $routeInfo) : \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode
    {
        return new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode(['path' => $routeInfo->getPath(), 'methods' => $routeInfo->getHttpMethods()]);
    }
    private function completeImplicitRoutes() : void
    {
        $presenterClasses = $this->nodeRepository->findClassesBySuffix('Presenter');
        foreach ($presenterClasses as $presenterClass) {
            foreach ($presenterClass->getMethods() as $classMethod) {
                if ($this->shouldSkipClassMethod($classMethod)) {
                    continue;
                }
                $path = $this->resolvePathFromClassAndMethodNodes($presenterClass, $classMethod);
                $symfonyRoutePhpDocTagValueNode = new \_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode(['path' => $path]);
                $this->explicitRouteAnnotationDecorator->decorateClassMethodWithRouteAnnotation($classMethod, $symfonyRoutePhpDocTagValueNode);
            }
        }
    }
    private function isRouteStaticCallMatch(\_PhpScoper0a6b37af0871\PhpParser\Node\Expr\StaticCall $staticCall) : bool
    {
        $className = $this->getName($staticCall->class);
        if ($className === null) {
            return \false;
        }
        $methodName = $this->getName($staticCall->name);
        if ($methodName === null) {
            return \false;
        }
        if (!\method_exists($className, $methodName)) {
            return \false;
        }
        $reflectionMethod = new \ReflectionMethod($className, $methodName);
        if ($reflectionMethod->getReturnType() === null) {
            return \false;
        }
        $staticCallReturnType = (string) $reflectionMethod->getReturnType();
        return \is_a($staticCallReturnType, '_PhpScoper0a6b37af0871\\Nette\\Application\\IRouter', \true);
    }
    private function shouldSkipClassMethod(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : bool
    {
        // not an action method
        if (!$classMethod->isPublic()) {
            return \true;
        }
        if (!$this->isName($classMethod, '#^(render|action)#')) {
            return \true;
        }
        $hasRouteAnnotation = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NetteToSymfony\Routing\ExplicitRouteAnnotationDecorator::HAS_ROUTE_ANNOTATION);
        if ($hasRouteAnnotation) {
            return \true;
        }
        // already has Route tag
        $phpDocInfo = $classMethod->getAttribute(\_PhpScoper0a6b37af0871\Rector\NodeTypeResolver\Node\AttributeKey::PHP_DOC_INFO);
        if ($phpDocInfo === null) {
            return \false;
        }
        return $phpDocInfo->hasByType(\_PhpScoper0a6b37af0871\Rector\BetterPhpDocParser\ValueObject\PhpDocNode\Symfony\SymfonyRouteTagValueNode::class);
    }
    private function resolvePathFromClassAndMethodNodes(\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Class_ $class, \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\ClassMethod $classMethod) : string
    {
        /** @var string $presenterName */
        $presenterName = $this->getName($class);
        /** @var string $presenterPart */
        $presenterPart = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::after($presenterName, '\\', -1);
        /** @var string $presenterPart */
        $presenterPart = \_PhpScoper0a6b37af0871\Nette\Utils\Strings::substring($presenterPart, 0, -\_PhpScoper0a6b37af0871\Nette\Utils\Strings::length('Presenter'));
        $presenterPart = \_PhpScoper0a6b37af0871\Rector\Core\Util\StaticRectorStrings::camelCaseToDashes($presenterPart);
        $match = (array) \_PhpScoper0a6b37af0871\Nette\Utils\Strings::match($this->getName($classMethod), self::ACTION_RENDER_NAME_MATCHING_REGEX);
        $actionPart = \lcfirst($match['short_action_name']);
        return $presenterPart . '/' . $actionPart;
    }
}
