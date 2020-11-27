<?php

namespace _PhpScoper006a73f0e455\PrivatePropertyWithTags;

use _PhpScoper006a73f0e455\Doctrine\ORM\Mapping as ORM;
class Foo
{
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     */
    private $title;
    /**
     * @get
     */
    private $text;
    /**
     * @ORM\Column(type="big_integer", options={"unsigned": true})
     * @get
     */
    private $author;
}
