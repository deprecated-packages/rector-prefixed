<?php

declare (strict_types=1);
namespace _PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder;

use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlock\Tags\Return_;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlockFactory;
use _PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\Type;
use PhpParser\Node\Stmt\Namespace_;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use _PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function explode;
class FindReturnType
{
    /** @var ResolveTypes */
    private $resolveTypes;
    /** @var DocBlockFactory */
    private $docBlockFactory;
    /** @var NamespaceNodeToReflectionTypeContext */
    private $makeContext;
    public function __construct()
    {
        $this->resolveTypes = new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \_PhpScoperbd5d0c5f7638\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \_PhpScoperbd5d0c5f7638\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a function, attempt to find the return type.
     *
     * @return Type[]
     */
    public function __invoke(\_PhpScoperbd5d0c5f7638\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\PhpParser\Node\Stmt\Namespace_ $namespace) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Return_[] $returnTags */
        $returnTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('return');
        foreach ($returnTags as $returnTag) {
            return $this->resolveTypes->__invoke(\explode('|', (string) $returnTag->getType()), $context);
        }
        return [];
    }
}
