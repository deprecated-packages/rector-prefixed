<?php

declare (strict_types=1);
namespace RectorPrefix20210217\Symplify\PhpConfigPrinter\ExprResolver;

use PhpParser\Node\Expr;
use RectorPrefix20210217\Symfony\Component\Yaml\Tag\TaggedValue;
use RectorPrefix20210217\Symplify\PhpConfigPrinter\ValueObject\FunctionName;
final class TaggedServiceResolver
{
    /**
     * @var ServiceReferenceExprResolver
     */
    private $serviceReferenceExprResolver;
    public function __construct(\RectorPrefix20210217\Symplify\PhpConfigPrinter\ExprResolver\ServiceReferenceExprResolver $serviceReferenceExprResolver)
    {
        $this->serviceReferenceExprResolver = $serviceReferenceExprResolver;
    }
    public function resolve(\RectorPrefix20210217\Symfony\Component\Yaml\Tag\TaggedValue $taggedValue) : \PhpParser\Node\Expr
    {
        $serviceName = $taggedValue->getValue()['class'];
        $functionName = \RectorPrefix20210217\Symplify\PhpConfigPrinter\ValueObject\FunctionName::INLINE_SERVICE;
        return $this->serviceReferenceExprResolver->resolveServiceReferenceExpr($serviceName, \false, $functionName);
    }
}
