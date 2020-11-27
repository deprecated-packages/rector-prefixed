<?php

declare (strict_types=1);
namespace Rector\PHPStanExtensions\NodeAnalyzer;

use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\StaticCall;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeFinder;
use Symplify\PHPStanRules\Naming\SimpleNameResolver;
use Symplify\PHPStanRules\ValueObject\PHPStanAttributeKey;
final class SymfonyConfigRectorValueObjectResolver
{
    /**
     * @var string
     */
    private const INLINE_CLASS_NAME = 'Symplify\\SymfonyPhpConfig\\ValueObjectInliner';
    /**
     * @var NodeFinder
     */
    private $nodeFinder;
    /**
     * @var SimpleNameResolver
     */
    private $simpleNameResolver;
    public function __construct(\PhpParser\NodeFinder $nodeFinder, \Symplify\PHPStanRules\Naming\SimpleNameResolver $simpleNameResolver)
    {
        $this->nodeFinder = $nodeFinder;
        $this->simpleNameResolver = $simpleNameResolver;
    }
    public function resolveFromSetMethodCall(\PhpParser\Node\Expr\MethodCall $methodCall) : ?string
    {
        $parent = $methodCall->getAttribute(\Symplify\PHPStanRules\ValueObject\PHPStanAttributeKey::PARENT);
        while (!$parent instanceof \PhpParser\Node\Stmt\Expression) {
            $parent = $parent->getAttribute(\Symplify\PHPStanRules\ValueObject\PHPStanAttributeKey::PARENT);
        }
        /** @var StaticCall|null $inlineStaticCall */
        $inlineStaticCall = $this->nodeFinder->findFirst($parent, function (\PhpParser\Node $node) : bool {
            if (!$node instanceof \PhpParser\Node\Expr\StaticCall) {
                return \false;
            }
            return $this->simpleNameResolver->isName($node->class, self::INLINE_CLASS_NAME);
        });
        if ($inlineStaticCall === null) {
            return null;
        }
        /** @var New_|null $new */
        $new = $this->nodeFinder->findFirstInstanceOf($inlineStaticCall, \PhpParser\Node\Expr\New_::class);
        if ($new === null) {
            return null;
        }
        return $this->simpleNameResolver->getName($new->class);
    }
}
