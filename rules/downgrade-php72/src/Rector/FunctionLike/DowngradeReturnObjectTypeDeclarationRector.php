<?php

declare (strict_types=1);
namespace Rector\DowngradePhp72\Rector\FunctionLike;

use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp72\Tests\Rector\FunctionLike\DowngradeReturnObjectTypeDeclarationRector\DowngradeReturnObjectTypeDeclarationRectorTest
 */
final class DowngradeReturnObjectTypeDeclarationRector extends \Rector\DowngradePhp72\Rector\FunctionLike\AbstractDowngradeReturnTypeDeclarationRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition($this->getRectorDefinitionDescription(), [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoper006a73f0e455;

class SomeClass
{
    public function getSomeObject() : object
    {
        return new \_PhpScoper006a73f0e455\SomeObject();
    }
}
\class_alias('_PhpScoper006a73f0e455\\SomeClass', 'SomeClass', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScoper006a73f0e455;

class SomeClass
{
    /**
     * @return object
     */
    public function getSomeObject()
    {
        return new \_PhpScoper006a73f0e455\SomeObject();
    }
}
\class_alias('_PhpScoper006a73f0e455\\SomeClass', 'SomeClass', \false);
CODE_SAMPLE
, [self::ADD_DOC_BLOCK => \true])]);
    }
    public function getTypeNameToRemove() : string
    {
        return 'object';
    }
}
