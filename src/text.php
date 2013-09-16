<?php

namespace willwashburn;

class text extends element
{
    protected $field_type = 'text';
    protected $placeholder, $max_length, $value;
    protected $prepended, $appended;


    /*
    * Construct
    * @oa	Will
    */

    public function __construct($label, $placeholder = false, $max_length = false, $value = false)
    {
        $this->label       = $label;
        $this->placeholder = $placeholder;
        $this->max_length  = $max_length;
        $this->value       = $value;
    }

    /*
    * Prepend
    * @oa	Will
    */

    public function append($text)
    {
        $this->appended = $text;
    }

    /*
    * Append
    * @oa	Will
    */

    public function prepend($text)
    {
        $this->prepended = $text;
    }

    /*
    * Render
    * @oa	Will
    *
    */

    public function render($name)
    {
        parent::render($name);

        if ($this->label) {
            $this->html = $this->label();
        }

        if ($this->prepended || $this->appended) {
            $div_class = '';
            if ($this->prepended) {
                $div_class .= ' input-prepend';
            }
            if ($this->appended) {
                $div_class .= ' input-append';
            }
            $this->html .= '<div class="' . $div_class . '">';
        }
        if ($this->prepended) {
            $this->html .= '<span class="add-on">' . $this->prepended . '</span>';
        }

        $this->html .= $this->rendered_input($name);

        if ($this->appended) {
            $this->html .= '<span class="add-on">' . $this->appended . '</span>';
        }

        if ($this->prepended || $this->appended) {
            $this->html .= '</div>';
        }

        return $this->html;

    }

    /*
    * Just the input part as textarea will change
    * @author Will
    */

    public function rendered_input($name)
    {

        if ($this->max_length) {
            $this->element_attributes .= ' maxlength= "' . $this->max_length . '"';
        }

        if ($this->placeholder) {
            $this->element_attributes .= ' placeholder="' . $this->placeholder . '"';
        }

        if ($this->value) {
            $this->element_attributes .= ' value= "' . $this->value . '"';
        }

        return '<input name="' . $name . '" type="' . $this->field_type . '" ' . $this->element_attributes . ' />';
    }

}