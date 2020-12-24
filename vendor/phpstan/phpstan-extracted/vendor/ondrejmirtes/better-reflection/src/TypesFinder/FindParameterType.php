<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder;

use LogicException;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Param;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Error;
use _PhpScoper0a6b37af0871\PhpParser\Node\Param as ParamNode;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use _PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
use function explode;
class FindParameterType
{
    /** @var ResolveTypes */
    private $resolveTypes;
    /** @var DocBlockFactory */
    private $docBlockFactory;
    /** @var NamespaceNodeToReflectionTypeContext */
    private $makeContext;
    public function __construct()
    {
        $this->resolveTypes = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a function and parameter, attempt to find the type of the parameter.
     *
     * @return Type[]
     */
    public function __invoke(\_PhpScoper0a6b37af0871\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Namespace_ $namespace, \_PhpScoper0a6b37af0871\PhpParser\Node\Param $node) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Param[] $paramTags */
        $paramTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('param');
        foreach ($paramTags as $paramTag) {
            if ($node->var instanceof \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Error) {
                throw new \LogicException('PhpParser left an "Error" node in the parameters AST, this should NOT happen');
            }
            if ($paramTag->getVariableName() === $node->var->name) {
                return $this->resolveTypes->__invoke(\explode('|', (string) $paramTag->getType()), $context);
            }
        }
        return [];
    }
}
