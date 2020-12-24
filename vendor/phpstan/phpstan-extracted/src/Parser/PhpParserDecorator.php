<?php

declare (strict_types=1);
namespace _PhpScopere8e811afab72\PHPStan\Parser;

use _PhpScopere8e811afab72\PhpParser\ErrorHandler;
class PhpParserDecorator implements \_PhpScopere8e811afab72\PhpParser\Parser
{
    /** @var \PHPStan\Parser\Parser */
    private $wrappedParser;
    public function __construct(\_PhpScopere8e811afab72\PHPStan\Parser\Parser $wrappedParser)
    {
        $this->wrappedParser = $wrappedParser;
    }
    /**
     * @param string $code
     * @param \PhpParser\ErrorHandler|null $errorHandler
     * @return \PhpParser\Node\Stmt[]
     */
    public function parse(string $code, ?\_PhpScopere8e811afab72\PhpParser\ErrorHandler $errorHandler = null) : array
    {
        try {
            return $this->wrappedParser->parseString($code);
        } catch (\_PhpScopere8e811afab72\PHPStan\Parser\ParserErrorsException $e) {
            $message = $e->getMessage();
            if ($e->getParsedFile() !== null) {
                $message .= \sprintf(' in file %s', $e->getParsedFile());
            }
            throw new \_PhpScopere8e811afab72\PhpParser\Error($message);
        }
    }
}
