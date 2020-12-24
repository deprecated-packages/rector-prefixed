<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source;

final class Denormalizer
{
    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;
    public function __construct(\_PhpScoper0a6b37af0871\Rector\PHPUnit\Tests\Rector\ClassMethod\AddDoesNotPerformAssertionToNonAssertingTestRector\Source\DenormalizerInterface $denormalizer)
    {
        $this->denormalizer = $denormalizer;
    }
    public function handle(array $data, string $type) : ?array
    {
        try {
            return $this->denormalizer->denormalize($data, $type);
        } catch (\Throwable $throwable) {
            return null;
        }
    }
}
