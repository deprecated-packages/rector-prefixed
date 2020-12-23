<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\PHPStan\Rules;

class RuleErrorBuilder
{
    private const TYPE_MESSAGE = 1;
    private const TYPE_LINE = 2;
    private const TYPE_FILE = 4;
    private const TYPE_TIP = 8;
    private const TYPE_IDENTIFIER = 16;
    private const TYPE_METADATA = 32;
    private const TYPE_NON_IGNORABLE = 64;
    /** @var int */
    private $type;
    /** @var mixed[] */
    private $properties;
    private function __construct(string $message)
    {
        $this->properties['message'] = $message;
        $this->type = self::TYPE_MESSAGE;
    }
    /**
     * @return array<int, array{string, string|null, string|null, string|null}>
     */
    public static function getRuleErrorTypes() : array
    {
        return [self::TYPE_MESSAGE => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleError::class, 'message', 'string', 'string'], self::TYPE_LINE => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\LineRuleError::class, 'line', 'int', 'int'], self::TYPE_FILE => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\FileRuleError::class, 'file', 'string', 'string'], self::TYPE_TIP => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\TipRuleError::class, 'tip', 'string', 'string'], self::TYPE_IDENTIFIER => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\IdentifierRuleError::class, 'identifier', 'string', 'string'], self::TYPE_METADATA => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\MetadataRuleError::class, 'metadata', 'array', 'mixed[]'], self::TYPE_NON_IGNORABLE => [\_PhpScoper0a2ac50786fa\PHPStan\Rules\NonIgnorableRuleError::class, null, null, null]];
    }
    public static function message(string $message) : self
    {
        return new self($message);
    }
    public function line(int $line) : self
    {
        $this->properties['line'] = $line;
        $this->type |= self::TYPE_LINE;
        return $this;
    }
    public function file(string $file) : self
    {
        $this->properties['file'] = $file;
        $this->type |= self::TYPE_FILE;
        return $this;
    }
    public function tip(string $tip) : self
    {
        $this->properties['tip'] = $tip;
        $this->type |= self::TYPE_TIP;
        return $this;
    }
    public function discoveringSymbolsTip() : self
    {
        return $this->tip('Learn more at https://phpstan.org/user-guide/discovering-symbols');
    }
    public function identifier(string $identifier) : self
    {
        $this->properties['identifier'] = $identifier;
        $this->type |= self::TYPE_IDENTIFIER;
        return $this;
    }
    /**
     * @param mixed[] $metadata
     */
    public function metadata(array $metadata) : self
    {
        $this->properties['metadata'] = $metadata;
        $this->type |= self::TYPE_METADATA;
        return $this;
    }
    public function nonIgnorable() : self
    {
        $this->type |= self::TYPE_NON_IGNORABLE;
        return $this;
    }
    public function build() : \_PhpScoper0a2ac50786fa\PHPStan\Rules\RuleError
    {
        /** @var class-string<RuleError> $className */
        $className = \sprintf('PHPStan\\Rules\\RuleErrors\\RuleError%d', $this->type);
        if (!\class_exists($className)) {
            throw new \_PhpScoper0a2ac50786fa\PHPStan\ShouldNotHappenException(\sprintf('Class %s does not exist.', $className));
        }
        $ruleError = new $className();
        foreach ($this->properties as $propertyName => $value) {
            $ruleError->{$propertyName} = $value;
        }
        return $ruleError;
    }
}
