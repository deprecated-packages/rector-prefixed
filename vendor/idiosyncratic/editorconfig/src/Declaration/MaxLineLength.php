<?php

declare (strict_types=1);
namespace RectorPrefix20210508\Idiosyncratic\EditorConfig\Declaration;

use RectorPrefix20210508\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use function is_int;
final class MaxLineLength extends \RectorPrefix20210508\Idiosyncratic\EditorConfig\Declaration\Declaration
{
    public function getName() : string
    {
        return 'max_line_length';
    }
    /**
     * @inheritdoc
     */
    public function validateValue($value) : void
    {
        if ($value !== 'off' && (\is_int($value) === \false || $value < 1 === \true)) {
            throw new \RectorPrefix20210508\Idiosyncratic\EditorConfig\Exception\InvalidValue($this->getStringValue(), $this->getName());
        }
    }
}
