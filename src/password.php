<?php

namespace willwashburn;

/**
* Password Elements
* @author	Will
*
*/

class password extends text
{

    public function __construct($label, $placeholder = false, $max_length = false, $value = false)
    {
        parent::__construct($label, $placeholder, $max_length, $value);
        $this->field_type = 'password';
    }
}