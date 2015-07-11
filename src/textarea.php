<?php namespace WilliGant;

class textarea extends text
{
    public $rows, $cols;

    /*
    * Construct
    * @author Will
    */

    public function __construct($label, $value = false)
    {
        $this->label = $label;
        $this->value = $value;
    }

    public function rendered_input($name)
    {
        if (!$this->value) {
            $this->value = '';
        }

        $this->attributize('rows');
        $this->attributize('columns');

        return '<textarea name="' . $name . '" ' . $this->element_attributes . '>' . $this->value . '</textarea>';
    }
}