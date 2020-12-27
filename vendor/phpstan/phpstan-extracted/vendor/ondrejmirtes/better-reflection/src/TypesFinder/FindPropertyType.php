<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder;

use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Var_;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory;
use _HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use PhpParser\Node\Stmt\Namespace_;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty;
use _HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function array_map;
use function array_merge;
use function explode;
class FindPropertyType
{
    /** @var ResolveTypes */
    private $resolveTypes;
    /** @var DocBlockFactory */
    private $docBlockFactory;
    /** @var NamespaceNodeToReflectionTypeContext */
    private $makeContext;
    public function __construct()
    {
        $this->resolveTypes = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a property, attempt to find the type of the property.
     *
     * @return Type[]
     */
    public function __invoke(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionProperty $reflectionProperty, ?\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $docComment = $reflectionProperty->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Var_[] $varTags */
        $varTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('var');
        return \array_merge([], ...\array_map(function (\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Var_ $varTag) use($context) {
            return $this->resolveTypes->__invoke(\explode('|', (string) $varTag->getType()), $context);
        }, $varTags));
    }
}
