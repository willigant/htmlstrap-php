<?php
    namespace htmlstrap;

    /*
    * All form elements
    * @oa Will
    *
    * //WBN add mouseevents / handlers
    * //WBN add required / optional
    *
    * ///CLEAN
    *
    */
    abstract class element extends html
    {
        public $tabindex, $onClick;
        protected $element_name, $element_attributes = '';

        protected $label;
        public $label_id = FALSE;
        public $label_stlye = FALSE;
        public $label_class = FALSE;

        protected $disabled = FALSE;

        /*
        * Set input name
        * @oa	Will
        *
        */
        public function element_name($name)
        {
            $this->element_name = $name;
        }

        /*
        * Create label
        * @oa	Will
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

        /*
         * Disabled
         * @author Will
         *
         */
        public function disabled()
        {
            $this->disabled = TRUE;
        }

        /*
        * Enabled
        * @author Will
        *
        */
        public function enabled()
        {
            $this->disabled = FALSE;
        }

        /*
        * Render
        * @oa	Will
        *
        *  prepare the standard attributes for the element
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


    }

