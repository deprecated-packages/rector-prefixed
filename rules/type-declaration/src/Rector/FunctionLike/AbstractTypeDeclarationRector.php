<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\TypeDeclaration\Rector\FunctionLike;

use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\TypeDeclaration\PhpParserTypeAnalyzer;
use _PhpScopere8e811afab72\Rector\VendorLocker\VendorLockResolver;
/**
 * @see https://wiki.php.net/rfc/scalar_type_hints_v5
 * @see https://github.com/nikic/TypeUtil
 * @see https://github.com/nette/type-fixer
 * @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/3258
 */
abstract class AbstractTypeDeclarationRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
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
    public function autowireAbstractTypeDeclarationRector(\_PhpScopere8e811afab72\Rector\TypeDeclaration\PhpParserTypeAnalyzer $phpParserTypeAnalyzer, \_PhpScopere8e811afab72\Rector\VendorLocker\VendorLockResolver $vendorLockResolver) : void
    {
        $this->phpParserTypeAnalyzer = $phpParserTypeAnalyzer;
        $this->vendorLockResolver = $vendorLockResolver;
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class];
    }
}
