<?php

declare (strict_types=1);
namespace PHPStan\Rules\PhpDoc;

use PHPStan\PhpDocParser\Lexer\Lexer;
use PHPStan\PhpDocParser\Parser\PhpDocParser;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidPHPStanDocTagRule>
 */
class InvalidPHPStanDocTagRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\PhpDoc\InvalidPHPStanDocTagRule(self::getContainer()->getByType(\PHPStan\PhpDocParser\Lexer\Lexer::class), self::getContainer()->getByType(\PHPStan\PhpDocParser\Parser\PhpDocParser::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/invalid-phpstan-doc.php'], [['Unknown PHPDoc tag: @phpstan-extens', 7], ['Unknown PHPDoc tag: @phpstan-pararm', 14]]);
    }
}
