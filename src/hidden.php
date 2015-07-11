<?php  namespace WilliGant;

/*
* Hidden Elements
* @oa	Will
*
*/

class hidden extends text
{

    /*
    * Construct
    * @oa	Will
    */
    public function __construct($value)
    {
        $this->value      = $value;
        $this->field_type = 'hidden';
    }
}