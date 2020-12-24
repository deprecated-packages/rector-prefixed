<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper0a6b37af0871\PhpParser\Node\Arg;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable;
use _PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceCaseConverter implements \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a6b37af0871\PhpParser\Node\Expr\Variable(\_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \_PhpScoper0a6b37af0871\PhpParser\Node\Arg($classConstFetch)]);
        return new \_PhpScoper0a6b37af0871\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoper0a6b37af0871\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
