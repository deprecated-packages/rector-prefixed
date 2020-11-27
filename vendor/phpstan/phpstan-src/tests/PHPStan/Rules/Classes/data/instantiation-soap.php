<?php

namespace _PhpScoper88fe6e0ad041\TestInstantiation;

function () {
    throw new \SoapFault('Server', 123);
    throw new \SoapFault('Server', 'Some error message');
};
