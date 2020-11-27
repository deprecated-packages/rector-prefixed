<?php

declare (strict_types=1);
namespace Rector\DowngradePhp71\Rector\FunctionLike;

use PhpParser\Node\NullableType;
use PhpParser\Node\Param;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
/**
 * @see \Rector\DowngradePhp71\Tests\Rector\FunctionLike\DowngradeNullableTypeParamDeclarationRector\DowngradeNullableTypeParamDeclarationRectorTest
 */
final class DowngradeNullableTypeParamDeclarationRector extends \Rector\DowngradePhp71\Rector\FunctionLike\AbstractDowngradeParamDeclarationRector
{
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Remove the nullable type params, add @param tags instead', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample(<<<'CODE_SAMPLE'
<?php

namespace _PhpScoperbd5d0c5f7638;

class SomeClass
{
    public function run(?string $input)
    {
        // do something
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\SomeClass', 'SomeClass', \false);
CODE_SAMPLE
, <<<'CODE_SAMPLE'
<?php

namespace _PhpScoperbd5d0c5f7638;

class SomeClass
{
    /**
     * @param string|null $input
     */
    public function run($input)
    {
        // do something
    }
}
\class_alias('_PhpScoperbd5d0c5f7638\\SomeClass', 'SomeClass', \false);
CODE_SAMPLE
, [self::ADD_DOC_BLOCK => \true])]);
    }
    public function shouldRemoveParamDeclaration(\PhpParser\Node\Param $param) : bool
    {
        if ($param->variadic) {
            return \false;
        }
        if ($param->type === null) {
            return \false;
        }
        // Check it is the union type
        return $param->type instanceof \PhpParser\Node\NullableType;
    }
}
