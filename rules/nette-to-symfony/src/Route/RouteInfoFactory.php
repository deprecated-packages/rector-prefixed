<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\Route;

use _PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver;
use _PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\ParsedNodeCollector;
use _PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver;
final class RouteInfoFactory
{
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var ValueResolver
     */
    private $valueResolver;
    /**
     * @var ParsedNodeCollector
     */
    private $parsedNodeCollector;
    public function __construct(\_PhpScoper2a4e7ab1ecbc\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver, \_PhpScoper2a4e7ab1ecbc\Rector\NodeCollector\NodeCollector\ParsedNodeCollector $parsedNodeCollector, \_PhpScoper2a4e7ab1ecbc\Rector\Core\PhpParser\Node\Value\ValueResolver $valueResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->valueResolver = $valueResolver;
        $this->parsedNodeCollector = $parsedNodeCollector;
    }
    public function createFromNode(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node) : ?\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo
    {
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_) {
            if ($this->hasNoArg($node)) {
                return null;
            }
            return $this->createRouteInfoFromArgs($node);
        }
        // Route::create()
        if ($node instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\StaticCall) {
            if (!isset($node->args[0])) {
                return null;
            }
            if (!isset($node->args[1])) {
                return null;
            }
            if (!$this->nodeNameResolver->isNames($node->name, ['get', 'head', 'post', 'put', 'patch', 'delete'])) {
                return null;
            }
            /** @var string $methodName */
            $methodName = $this->nodeNameResolver->getName($node->name);
            $uppercasedMethodName = \strtoupper($methodName);
            $methods = [];
            if ($uppercasedMethodName !== null) {
                $methods[] = $uppercasedMethodName;
            }
            return $this->createRouteInfoFromArgs($node, $methods);
        }
        return null;
    }
    private function hasNoArg(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\New_ $new) : bool
    {
        if (!isset($new->args[0])) {
            return \true;
        }
        return !isset($new->args[1]);
    }
    /**
     * @param New_|StaticCall $node
     * @param string[] $methods
     */
    private function createRouteInfoFromArgs(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $methods = []) : ?\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo
    {
        $pathArgument = $node->args[0]->value;
        $routePath = $this->valueResolver->getValue($pathArgument);
        // route path is needed
        if ($routePath === null) {
            return null;
        }
        if (!\is_string($routePath)) {
            return null;
        }
        $routePath = $this->normalizeArgumentWrappers($routePath);
        $targetNode = $node->args[1]->value;
        if ($targetNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Expr\ClassConstFetch) {
            return $this->createForClassConstFetch($node, $methods, $routePath);
        }
        if ($targetNode instanceof \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_) {
            return $this->createForString($targetNode, $routePath);
        }
        return null;
    }
    private function normalizeArgumentWrappers(string $routePath) : string
    {
        return \str_replace(['<', '>'], ['{', '}'], $routePath);
    }
    /**
     * @param New_|StaticCall $node
     * @param string[] $methods
     */
    private function createForClassConstFetch(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node $node, array $methods, string $routePath) : ?\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo
    {
        /** @var ClassConstFetch $controllerMethodNode */
        $controllerMethodNode = $node->args[1]->value;
        // SomePresenter::class
        if ($this->nodeNameResolver->isName($controllerMethodNode->name, 'class')) {
            $presenterClass = $this->nodeNameResolver->getName($controllerMethodNode->class);
            if ($presenterClass === null) {
                return null;
            }
            if (!\class_exists($presenterClass)) {
                return null;
            }
            if (\method_exists($presenterClass, 'run')) {
                return new \_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo($presenterClass, 'run', $routePath, $methods);
            }
        }
        return null;
    }
    private function createForString(\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Scalar\String_ $string, string $routePath) : ?\_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo
    {
        $targetValue = $string->value;
        if (!\_PhpScoper2a4e7ab1ecbc\Nette\Utils\Strings::contains($targetValue, ':')) {
            return null;
        }
        [$controller, $method] = \explode(':', $targetValue);
        // detect class by controller name?
        // foreach all instance and try to match a name $controller . 'Presenter/Controller'
        $classNode = $this->parsedNodeCollector->findByShortName($controller . 'Presenter');
        if ($classNode === null) {
            $classNode = $this->parsedNodeCollector->findByShortName($controller . 'Controller');
        }
        // unable to find here
        if ($classNode === null) {
            return null;
        }
        $controllerClass = $this->nodeNameResolver->getName($classNode);
        if ($controllerClass === null) {
            return null;
        }
        $methodName = null;
        if (\method_exists($controllerClass, 'render' . \ucfirst($method))) {
            $methodName = 'render' . \ucfirst($method);
        } elseif (\method_exists($controllerClass, 'action' . \ucfirst($method))) {
            $methodName = 'action' . \ucfirst($method);
        }
        if ($methodName === null) {
            return null;
        }
        return new \_PhpScoper2a4e7ab1ecbc\Rector\NetteToSymfony\ValueObject\RouteInfo($controllerClass, $methodName, $routePath, []);
    }
}
