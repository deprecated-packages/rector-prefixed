<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\DoctrineAnnotationGenerated\DataCollector;

final class ResolvedConstantStaticCollector
{
    /**
     * @var array<string, mixed>
     */
    private static $valuesByIdentifier = [];
    /**
     * @param mixed $value
     */
    public static function collect(string $identifier, $value) : void
    {
        // skip PHP values
        $lowercasedIdentifier = \strtolower($identifier);
        if (\in_array($lowercasedIdentifier, ['true', 'false', 'null'], \true)) {
            return;
        }
        self::$valuesByIdentifier[$identifier] = $value;
    }
    /**
     * @return array<string, mixed>
     */
    public static function provide() : array
    {
        return self::$valuesByIdentifier;
    }
    public static function clear() : void
    {
        self::$valuesByIdentifier = [];
    }
}
