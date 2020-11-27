<?php

namespace Rector\PHPStanExtensions\Tests\Rule\ConfigurableRectorRule\Fixture;

use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Rector\PHPStanExtensions\Tests\Rule\ConfigurableRectorRule\Source\AbstractClassImplementsConfigurableInterface;
use Rector\Transform\ValueObject\StaticCallToFuncCall;
class ImplementsThroughAbstractClassRector extends \Rector\PHPStanExtensions\Tests\Rule\ConfigurableRectorRule\Source\AbstractClassImplementsConfigurableInterface
{
    /**
     * @var string
     */
    public const STATIC_CALLS_TO_FUNCTIONS = 'static_calls_to_functions';
    public function configure(array $configuration) : void
    {
        // TODO: Implement configure() method.
    }
    public function getRuleDefinition() : \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
    {
        return new \Symplify\RuleDocGenerator\ValueObject\RuleDefinition('Turns static call to function call.', [new \Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample('OldClass::oldMethod("args");', 'new_function("args");', [self::STATIC_CALLS_TO_FUNCTIONS => [new \Rector\Transform\ValueObject\StaticCallToFuncCall('OldClass', 'oldMethod', 'new_function')]])]);
    }
}
