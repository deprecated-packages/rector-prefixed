<?php

declare (strict_types=1);
namespace _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod;
use _PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_;
use _PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector;
use _PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PhpParserTypeAnalyzer;
use _PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\VendorLockResolver;
/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 * @see https://github.com/nikic/TypeUtil
 * @see https://github.com/nette/type-fixer
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/3258
 */
abstract class AbstractTypeDeclarationRector extends \_PhpScoper2a4e7ab1ecbc\Rector\Core\Rector\AbstractRector
{
    /**
     * @var PhpParserTypeAnalyzer
     */
    protected $phpParserTypeAnalyzer;
    /**
     * @var VendorLockResolver
     */
    protected $vendorLockResolver;
    /**
     * @required
     */
    public function autowireAbstractTypeDeclarationRector(\_PhpScoper2a4e7ab1ecbc\Rector\TypeDeclaration\PhpParserTypeAnalyzer $phpParserTypeAnalyzer, \_PhpScoper2a4e7ab1ecbc\Rector\VendorLocker\VendorLockResolver $vendorLockResolver) : void
    {
        $this->phpParserTypeAnalyzer = $phpParserTypeAnalyzer;
        $this->vendorLockResolver = $vendorLockResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\Function_::class, \_PhpScoper2a4e7ab1ecbc\PhpParser\Node\Stmt\ClassMethod::class];
    }
}
