<?php

declare (strict_types=1);
namespace _HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr;

use _HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier;
use function array_map;
use function array_merge;
use function array_unique;
use function array_values;
use function rtrim;
use function str_replace;
use function strpos;
final class Psr0Mapping implements \_HumbugBox221ad6f1b81f\Roave\BetterReflection\SourceLocator\Type\Composer\Psr\PsrAutoloaderMapping
{
    /** @var array<string, array<int, string>> */
    private $mappings = [];
    private function __construct()
    {
    }
    /** @param array<string, array<int, string>> $mappings */
    public static function fromArrayMappings(array $mappings) : self
    {
        $instance = new self();
        $instance->mappings = \array_map(static function (array $directories) : array {
            return \array_map(static function (string $directory) : string {
                return \rtrim($directory, '/');
            }, $directories);
        }, $mappings);
        return $instance;
    }
    /** {@inheritDoc} */
    public function resolvePossibleFilePaths(\_HumbugBox221ad6f1b81f\Roave\BetterReflection\Identifier\Identifier $identifier) : array
    {
        if (!$identifier->isClass()) {
            return [];
        }
        $className = $identifier->getName();
        foreach ($this->mappings as $prefix => $paths) {
            if ($prefix === '') {
                continue;
            }
            if (\strpos($className, $prefix) === 0) {
                return \array_map(static function (string $path) use($className) : string {
                    return \rtrim($path, '/') . '/' . \str_replace(['\\', '_'], '/', $className) . '.php';
                }, $paths);
            }
        }
        return [];
    }
    /** {@inheritDoc} */
    public function directories() : array
    {
        return \array_values(\array_unique(\array_merge([], ...\array_values($this->mappings))));
    }
}
