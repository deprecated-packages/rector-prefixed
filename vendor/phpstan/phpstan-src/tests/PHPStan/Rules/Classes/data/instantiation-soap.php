<?php

namespace _PhpScoperbd5d0c5f7638\TestInstantiation;

function () {
    throw new \SoapFault('Server', 123);
    throw new \SoapFault('Server', 'Some error message');
};
