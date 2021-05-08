<?php

declare (strict_types=1);
namespace RectorPrefix20210508\Idiosyncratic\EditorConfig\Declaration;

use RectorPrefix20210508\Idiosyncratic\EditorConfig\Exception\InvalidValue;
use function is_int;
final class TabWidth extends \RectorPrefix20210508\Idiosyncratic\EditorConfig\Declaration\Declaration
{
    public function getName() : string
    {
        return 'tab_width';
    }
    /**
     * @inheritdoc
     */
    public function validateValue($value) : void
    {
        if (\is_int($value) === \false || $value < 1 === \true) {
            throw new \RectorPrefix20210508\Idiosyncratic\EditorConfig\Exception\InvalidValue($this->getStringValue(), $this->getName());
        }
    }
}
