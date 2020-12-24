<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder;

use LogicException;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlock\Tags\Param;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\Type;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Error;
use _PhpScopere8e811afab72\PhpParser\Node\Param as ParamNode;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract;
use _PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext;
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
        $this->resolveTypes = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\ResolveTypes();
        $this->docBlockFactory = \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\phpDocumentor\Reflection\DocBlockFactory::createInstance();
        $this->makeContext = new \_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\TypesFinder\PhpDocumentor\NamespaceNodeToReflectionTypeContext();
    }
    /**
     * Given a function and parameter, attempt to find the type of the parameter.
     *
     * @return Type[]
     */
    public function __invoke(\_PhpScopere8e811afab72\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Reflection\ReflectionFunctionAbstract $function, ?\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Namespace_ $namespace, \_PhpScopere8e811afab72\PhpParser\Node\Param $node) : array
    {
        $docComment = $function->getDocComment();
        if ($docComment === '') {
            return [];
        }
        $context = $this->makeContext->__invoke($namespace);
        /** @var Param[] $paramTags */
        $paramTags = $this->docBlockFactory->create($docComment, $context)->getTagsByName('param');
        foreach ($paramTags as $paramTag) {
            if ($node->var instanceof \_PhpScopere8e811afab72\PhpParser\Node\Expr\Error) {
                throw new \LogicException('PhpParser left an "Error" node in the parameters AST, this should NOT happen');
            }
            if ($paramTag->getVariableName() === $node->var->name) {
                return $this->resolveTypes->__invoke(\explode('|', (string) $paramTag->getType()), $context);
            }
        }
        return [];
    }
}
