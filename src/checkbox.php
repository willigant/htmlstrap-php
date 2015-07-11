<?php  namespace WilliGant;

/*
* Checkbox Elements
* @author Khaliq
*/

class checkbox extends text
{
    /*
     * Contstruct
     * @oa Khaliq
     */
    public function __construct($label)
    {
        $this->label      = $label;
        $this->field_type = 'checkbox';
    }

    public function render($name)
    {
        return '<input type="' . $this->field_type . '" value="' . $this->label . '"> ' . $this->label . '<label for="' . $name . '"></label>';
    }
}