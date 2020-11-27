<?php

namespace _PhpScoper006a73f0e455\TestInstantiation;

function () {
    throw new \SoapFault('Server', 123);
    throw new \SoapFault('Server', 'Some error message');
};
