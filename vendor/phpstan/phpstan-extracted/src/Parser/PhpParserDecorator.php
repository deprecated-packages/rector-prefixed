<?php

declare (strict_types=1);
namespace RectorPrefix20201227\PHPStan\Parser;

use PhpParser\ErrorHandler;
class PhpParserDecorator implements \PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\RectorPrefix20201227\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\RectorPrefix20201227\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \PhpParser\Error($message);
        }
    }
}
