<?php

namespace _PhpScoper26e51eeacccf\Bug3683;

function (\Generator $g) : void {
    $g->throw(new \Exception());
    $g->throw(1);
};
