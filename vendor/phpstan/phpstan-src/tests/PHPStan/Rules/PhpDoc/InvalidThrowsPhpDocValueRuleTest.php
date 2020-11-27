<?php

declare (strict_types=1);
namespace PHPStan\Rules\PhpDoc;

use PHPStan\Type\FileTypeMapper;
use PHPStan\Type\VerbosityLevel;
/**
 * @extends \PHPStan\Testing\RuleTestCase<InvalidThrowsPhpDocValueRule>
 */
class InvalidThrowsPhpDocValueRuleTest extends \PHPStan\Testing\RuleTestCase
{
    protected function getRule() : \PHPStan\Rules\Rule
    {
        return new \PHPStan\Rules\PhpDoc\InvalidThrowsPhpDocValueRule(self::getContainer()->getByType(\PHPStan\Type\FileTypeMapper::class));
    }
    public function testRule() : void
    {
        $this->analyse([__DIR__ . '/data/incompatible-throws.php'], [['PHPDoc tag @throws with type Undefined is not subtype of Throwable', 54], ['PHPDoc tag @throws with type bool is not subtype of Throwable', 61], ['PHPDoc tag @throws with type DateTimeImmutable is not subtype of Throwable', 68], ['PHPDoc tag @throws with type DateTimeImmutable|Throwable is not subtype of Throwable', 75], ['PHPDoc tag @throws with type DateTimeImmutable&IteratorAggregate is not subtype of Throwable', 82], ['PHPDoc tag @throws with type Throwable|void is not subtype of Throwable', 96], ['PHPDoc tag @throws with type stdClass|void is not subtype of Throwable', 103]]);
    }
    public function testInheritedPhpDocs() : void
    {
        $this->analyse([__DIR__ . '/data/merge-inherited-throws.php'], [['PHPDoc tag @throws with type InvalidThrowsPhpDocMergeInherited\\A is not subtype of Throwable', 13], ['PHPDoc tag @throws with type InvalidThrowsPhpDocMergeInherited\\B is not subtype of Throwable', 19], ['PHPDoc tag @throws with type InvalidThrowsPhpDocMergeInherited\\C|InvalidThrowsPhpDocMergeInherited\\D is not subtype of Throwable', 28]]);
    }
    public function dataMergeInheritedPhpDocs() : array
    {
        return [[\_PhpScoper88fe6e0ad041\InvalidThrowsPhpDocMergeInherited\Two::class, 'method', '_PhpScoper88fe6e0ad041\\InvalidThrowsPhpDocMergeInherited\\C|InvalidThrowsPhpDocMergeInherited\\D'], [\_PhpScoper88fe6e0ad041\InvalidThrowsPhpDocMergeInherited\Three::class, 'method', '_PhpScoper88fe6e0ad041\\InvalidThrowsPhpDocMergeInherited\\C|InvalidThrowsPhpDocMergeInherited\\D'], [\_PhpScoper88fe6e0ad041\InvalidThrowsPhpDocMergeInherited\Four::class, 'method', '_PhpScoper88fe6e0ad041\\InvalidThrowsPhpDocMergeInherited\\C|InvalidThrowsPhpDocMergeInherited\\D']];
    }
    /**
     * @dataProvider dataMergeInheritedPhpDocs
     * @param string $className
     * @param string $method
     * @param string $expectedType
     */
    public function testMergeInheritedPhpDocs(string $className, string $method, string $expectedType) : void
    {
        $reflectionProvider = $this->createBroker();
        $reflection = $reflectionProvider->getClass($className);
        $method = $reflection->getNativeMethod($method);
        $throwsType = $method->getThrowType();
        $this->assertNotNull($throwsType);
        $this->assertSame($expectedType, $throwsType->describe(\PHPStan\Type\VerbosityLevel::precise()));
    }
}