<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\CaseConverter;

use _PhpScoper0a2ac50786fa\PhpParser\Node\Arg;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable;
use _PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\VariableName;
use _PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\YamlKey;
/**
 * Handles this part:
 *
 * services:
 *     SomeNamespace\SomeClass: null <---
 */
final class NameOnlyServiceCaseConverter implements \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\Contract\CaseConverterInterface
{
    /**
     * @var CommonNodeFactory
     */
    private $commonNodeFactory;
    public function __construct(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\NodeFactory\CommonNodeFactory $commonNodeFactory)
    {
        $this->commonNodeFactory = $commonNodeFactory;
    }
    public function convertToMethodCall($key, $values) : \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression
    {
        $classConstFetch = $this->commonNodeFactory->createClassReference($key);
        $setMethodCall = new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\MethodCall(new \_PhpScoper0a2ac50786fa\PhpParser\Node\Expr\Variable(\_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\VariableName::SERVICES), 'set', [new \_PhpScoper0a2ac50786fa\PhpParser\Node\Arg($classConstFetch)]);
        return new \_PhpScoper0a2ac50786fa\PhpParser\Node\Stmt\Expression($setMethodCall);
    }
    public function match(string $rootKey, $key, $values) : bool
    {
        if ($rootKey !== \_PhpScoper0a2ac50786fa\Symplify\PhpConfigPrinter\ValueObject\YamlKey::SERVICES) {
            return \false;
        }
        return $values === null || $values === [];
    }
}
