<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\Rector\Php80\Rector\Class_;

use _PhpScopere8e811afab72\PhpParser\Node;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction;
use _PhpScopere8e811afab72\PhpParser\Node\Expr\Closure;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_;
use _PhpScopere8e811afab72\PhpParser\Node\Stmt\Property;
use _PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector;
use _PhpScopere8e811afab72\Rector\PhpAttribute\AnnotationToAttributeConverter;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use _PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see https://wiki.php.net/rfc/attributes_v2
 * @see https://wiki.php.net/rfc/shorter_attribute_syntax
 * @see https://wiki.php.net/rfc/shorter_attribute_syntax_change - FINAL #[...] syntax !
 *
 * @see \Rector\Php80\Tests\Rector\Class_\AnnotationToAttributeRector\AnnotationToAttributeRectorTest
 */
final class AnnotationToAttributeRector extends \_PhpScopere8e811afab72\Rector\Core\Rector\AbstractRector
{
    /**
     * @var AnnotationToAttributeConverter
     */
    private $annotationToAttributeConverter;
    public function __construct(\_PhpScopere8e811afab72\Rector\PhpAttribute\AnnotationToAttributeConverter $annotationToAttributeConverter)
    {
        $this->annotationToAttributeConverter = $annotationToAttributeConverter;
    }
    public function getRuleDefinition() : \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Change annotation to attribute', [new \_PhpScopere8e811afab72\Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample(<<<'CODE_SAMPLE'
use Doctrine\ORM\Attributes as ORM;

/**
  * @ORM\Entity
  */
class SomeClass
{
}
CODE_SAMPLE
, <<<'CODE_SAMPLE'
use Doctrine\ORM\Attributes as ORM;

#[ORM\Entity]
class SomeClass
{
}
CODE_SAMPLE
)]);
    }
    /**
     * @return string[]
     */
    public function getNodeTypes() : array
    {
        return [\_PhpScopere8e811afab72\PhpParser\Node\Stmt\Class_::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Property::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\ClassMethod::class, \_PhpScopere8e811afab72\PhpParser\Node\Stmt\Function_::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\Closure::class, \_PhpScopere8e811afab72\PhpParser\Node\Expr\ArrowFunction::class];
    }
    /**
     * @param Class_|Property|ClassMethod|Function_|Closure|ArrowFunction $node
     */
    public function refactor(\_PhpScopere8e811afab72\PhpParser\Node $node) : ?\_PhpScopere8e811afab72\PhpParser\Node
    {
        return $this->annotationToAttributeConverter->convertNode($node);
    }
}
