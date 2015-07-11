<?php  namespace WilliGant;

/*
* All form elements
* @author Will
*
* //WBN add mouseevents / handlers
* //WBN add required / optional
*
* ///CLEAN
*
*/
abstract class element extends html
{
    public $label_class = false;
    public $label_id = false;
    public $label_stlye = false;
    public $tabindex, $onClick;
    protected $disabled = false;
    protected $element_name, $element_attributes = '';
    protected $label;

    /*
    * Set input name
    * @oa	Will
    *
    */

    public function disabled()
    {
        $this->disabled = true;
    }

    /*
    * Create label
    * @oa	Will
    */

    public function element_name($name)
    {
        $this->element_name = $name;
    }

    /*
     * Disabled
     * @author Will
     *
     */

    public function enabled()
    {
        $this->disabled = false;
    }

    /*
    * Enabled
    * @author Will
    *
    */

    function render($name)
    {
        $this->attributize('class');
        $this->attributize('style');
        $this->attributize('onClick');


        ///WBN these should go in the attributize functions, right?
        $this->element_attributes .= $this->class;
        $this->element_attributes .= $this->style;
        $this->element_attributes .= $this->onClick;

        if ($this->id) {
            $this->element_attributes .= ' id="' . $this->id . '"';
        }
        if ($this->tabindex) {
            $this->element_attributes .= ' tabindex="' . $this->tabindex . '"';
        }

        if ($this->disabled) {
            $this->element_attributes .= ' disabled="disabled"';
        }
    }

    /*
    * Render
    * @oa	Will
    *
    *  prepare the standard attributes for the element
    */

    protected function label()
    {
        $label_attributes = ' for="' . $this->element_name . '"';

        if ($this->label_class) {
            $label_attributes .= ' class="' . $this->label_class . '"';
        }

        $html = "<label$label_attributes>$this->label</label>";

        return $html;
    }


}

