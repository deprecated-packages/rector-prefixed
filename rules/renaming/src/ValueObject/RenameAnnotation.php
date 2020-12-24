<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\Rector\Renaming\ValueObject;

final class RenameAnnotation
{
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $oldAnnotation;
    /**
     * @var string
     */
    private $newAnnotation;
    public function __construct(string $type, string $oldAnnotation, string $newAnnotation)
    {
        $this->type = $type;
        $this->oldAnnotation = $oldAnnotation;
        $this->newAnnotation = $newAnnotation;
    }
    public function getType() : string
    {
        return $this->type;
    }
    public function getOldAnnotation() : string
    {
        return $this->oldAnnotation;
    }
    public function getNewAnnotation() : string
    {
        return $this->newAnnotation;
    }
}
