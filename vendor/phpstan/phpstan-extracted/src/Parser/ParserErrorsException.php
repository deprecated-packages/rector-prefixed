<?php

declare (strict_types=1);
namespace _PhpScoper0a6b37af0871\PHPStan\Parser;

use _PhpScoper0a6b37af0871\PhpParser\Error;
class ParserErrorsException extends \Exception
{
    /** @var \PhpParser\Error[] */
    private $errors;
    /** @var string|null */
    private $parsedFile;
    /**
     * @param \PhpParser\Error[] $errors
     * @param string|null $parsedFile
     */
    public function __construct(array $errors, ?string $parsedFile)
    {
        parent::__construct(\implode(', ', \array_map(static function (\_PhpScoper0a6b37af0871\PhpParser\Error $error) : string {
            return $error->getMessage();
        }, $errors)));
        $this->errors = $errors;
        $this->parsedFile = $parsedFile;
    }
    /**
     * @return \PhpParser\Error[]
     */
    public function getErrors() : array
    {
        return $this->errors;
    }
    public function getParsedFile() : ?string
    {
        return $this->parsedFile;
    }
}
