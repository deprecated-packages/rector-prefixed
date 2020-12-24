<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Sensio\Helper;

use _PhpScopere8e811afab72\Nette\Utils\Strings;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException;
use _PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver;
use _PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey;
use _PhpScopere8e811afab72\Rector\Sensio\BundleClassResolver;
/**
 * @see \Rector\Sensio\Tests\Rector\ClassMethod\TemplateAnnotationToThisRenderRector\TemplateAnnotationToThisRenderRectorTest
 */
final class TemplateGuesser
{
    /**
     * @var string
     * @see https://regex101.com/r/yZAUAC/1
     */
    private const BUNDLE_SUFFIX_REGEX = '#Bundle$#';
    /**
     * @var string
     * @see https://regex101.com/r/T6ItFG/1
     */
    private const BUNDLE_NAME_MATCHING_REGEX = '#(?<bundle>[\\w]*Bundle)#';
    /**
     * @var string
     * @see https://regex101.com/r/5dNkCC/2
     */
    private const SMALL_LETTER_BIG_LETTER_REGEX = '#([a-z\\d])([A-Z])#';
    /**
     * @var string
     * @see https://regex101.com/r/YUrmAD/1
     */
    private const CONTROLLER_NAME_MATCH_REGEX = '#Controller\\\\(.+)Controller$#';
    /**
     * @var string
     * @see https://regex101.com/r/nj8Ojf/1
     */
    private const ACTION_MATCH_REGEX = '#Action$#';
    /**
     * @var NodeNameResolver
     */
    private $nodeNameResolver;
    /**
     * @var BundleClassResolver
     */
    private $bundleClassResolver;
    public function __construct(\_PhpScopere8e811afab72\Rector\Sensio\BundleClassResolver $bundleClassResolver, \_PhpScopere8e811afab72\Rector\NodeNameResolver\NodeNameResolver $nodeNameResolver)
    {
        $this->nodeNameResolver = $nodeNameResolver;
        $this->bundleClassResolver = $bundleClassResolver;
    }
    public function resolveFromClassMethodNode(\_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod $classMethod) : string
    {
        $namespace = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::NAMESPACE_NAME);
        if (!\is_string($namespace)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $class = $classMethod->getAttribute(\_PhpScopere8e811afab72\Rector\NodeTypeResolver\Node\AttributeKey::CLASS_NAME);
        if (!\is_string($class)) {
            throw new \_PhpScopere8e811afab72\Rector\Core\Exception\ShouldNotHappenException();
        }
        $methodName = $this->nodeNameResolver->getName($classMethod);
        return $this->resolve($namespace, $class, $methodName);
    }
    /**
     * Mimics https://github.com/sensiolabs/SensioFrameworkExtraBundle/blob/v5.0.0/Templating/TemplateGuesser.php
     */
    private function resolve(string $namespace, string $class, string $method) : string
    {
        $bundle = $this->resolveBundle($class, $namespace);
        $controller = $this->resolveController($class);
        $action = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($method, self::ACTION_MATCH_REGEX, '');
        $fullPath = '';
        if ($bundle !== '') {
            $fullPath .= $bundle . '/';
        }
        if ($controller !== '') {
            $fullPath .= $controller . '/';
        }
        return $fullPath . $action . '.html.twig';
    }
    private function resolveBundle(string $class, string $namespace) : string
    {
        $shortBundleClass = $this->bundleClassResolver->resolveShortBundleClassFromControllerClass($class);
        if ($shortBundleClass !== null) {
            return '@' . $shortBundleClass;
        }
        $bundle = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($namespace, self::BUNDLE_NAME_MATCHING_REGEX)['bundle'] ?? '';
        $bundle = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($bundle, self::BUNDLE_SUFFIX_REGEX, '');
        return $bundle !== '' ? '@' . $bundle : '';
    }
    private function resolveController(string $class) : string
    {
        $match = \_PhpScopere8e811afab72\Nette\Utils\Strings::match($class, self::CONTROLLER_NAME_MATCH_REGEX);
        if (!$match) {
            return '';
        }
        $controller = \_PhpScopere8e811afab72\Nette\Utils\Strings::replace($match[1], self::SMALL_LETTER_BIG_LETTER_REGEX, '_PhpScopere8e811afab72\\1_\\2');
        return \str_replace('\\', '/', $controller);
    }
}
