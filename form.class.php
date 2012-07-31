<?php

    /*
    * Formstrap PHP
    * Easily create bootstrap forms and form elements
    * obviously best with Twitter Bootstrap, but you could use it without
    *
    * Created by the same guys who built Social Blendr (www.socialblendr.com)
    * Copyright (c) 2012 WilliGant Ltd.
    *
    * founders@socialblendr.com
    *
    *
    * Permission is hereby granted, free of charge, to any person obtaining a copy
    * of this software and associated documentation files (the "Software"), to deal
    * in the Software without restriction, including without limitation the rights
    * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    * copies of the Software, and to permit persons to whom the Software is
    * furnished to do so, subject to the following conditions:
    *
    * The above copyright notice and this permission notice shall be included in
    * all copies or substantial portions of the Software.
    *
    * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
    * THE SOFTWARE.
    *
    * Inspired by the Nibble forms library
    * Copyright (c) 2010 Luke Rotherfield, Nibble Development
    *
    */


    namespace htmlstrap;

    require_once 'html.class.php';
    require_once 'element.class.php';
    require_once 'button.class.php';

    //WWBN allow different enctypes
    //WBN create quick forms like "search box" or "email_pw_login" w/ different options
    //WBN add control groups for horizontal forms

    class form extends html
    {

        protected $action = FALSE, $method = FALSE, $class = FALSE;
        private $fields;
        private static $token_session_name = 'formstrap_token', $first_form_on_page = TRUE;

        /*
        * Constructor
        * @oa	Will
        *
        * action  		where the form will post
        * method 		POST or GET
        * form_style	vertical, inline, search, horizontal (per twitter bootstrap)
        * well			some styling on the form
        *
        */
        public function __construct($action = '', $method = 'post', $form_style = 'vertical', $well = FALSE)
        {
            $this->fields = new \stdClass();

            if ($well) {
                $this->add_attribute('class', 'well');
            }
            $this->style($form_style);

            $this->method = strtoupper($method);
            $this->action = $action;
        }

        /*
        * Magic functions
        * @oa	Will
        *
        *
        */
        public function __set($name, $value)
        {
            $this->fields->$name = $value;
        }

        public function  __get($name)
        {
            if (isset($this->fields->$name)) {
                return $this->fields->$name;
            } else {
                return FALSE;
            }
        }

        /*
        * Change form style
        * @author Will
        */
        public function style($style)
        {
            $form_styles = array(
                'vertical', 'inline', 'search', 'horizontal'
            );
            foreach ($form_styles as $style) {
                $this->remove_attribute('class', 'form-' . $style);
            }
            if (in_array($style, $form_styles)) {
                $this->add_attribute('class', 'form-' . $style);
            } else {
                throw new \Exception('That form style does not exist');
            }
        }

        /*
        * Well
        * @author will
        */
        public function well($set = TRUE)
        {
            if ($set) {
                $this->add_attribute('class', 'well');
            } else {
                $this->remove_attribute('class', 'well');
            }
        }

        /*
        * Render
        * @oa Will
        *
        * returns the HTML of the form
        *
        */
        public function render()
        {

            $token = $this->crsf_token();
            $this->attributize('class');

            $html = '<form action="' . $this->action . '" ' . $this->class . ' method="' . $this->method . '"  enctype="enctype/form-data">';
            $html .= '<input id="' . self::$token_session_name . '" name="' . self::$token_session_name . '" type="hidden" value="' . $token . '" />';

            foreach ($this->fields as $name => $element) {
                if (is_object($element)) {
                    $element->element_name($name);
                    $html .= $element->render($name);
                } elseif (is_string($element)) {
                    $html .= $element;
                }
            }

            $html .= '</form>';

            return $html;
        }


        /*
        * Create token session
        * @oa Will
        *
        * //WTD check if the session is started
        *
        */
        private function crsf_token($length = 20)
        {
            $code  = "";
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
            srand((double)microtime() * 1000000);
            for ($i = 0; $i < $length; $i++) {
                $code .= substr($chars, rand() % strlen($chars), 1);
            }

            if (self::$first_form_on_page) {
                self::$first_form_on_page            = FALSE;
                $_SESSION[self::$token_session_name] = array();
            }

            if (is_string($_SESSION[self::$token_session_name])) {
                unset($_SESSION[self::$token_session_name]);
            }
            $_SESSION[self::$token_session_name][$code] = $code;

            return $code;
        }

        /*
        * Validate token session
        * @oa	Will
        *
        * //WTD check if the session is started
        *
        */
        static public function is_token_valid($method = 'POST')
        {
            if ($method === 'POST') {

                $token = $_POST[self::$token_session_name];
                if (array_key_exists($token, $_SESSION[self::$token_session_name])) {
                    if ($_POST[self::$token_session_name] == $_SESSION[self::$token_session_name][$token]) {
                        unset($_SESSION[self::$token_session_name][$token]);
                        return TRUE;
                    } else {
                        //double post
                        return TRUE;
                    }
                } else {
                    return FALSE;
                }
            } else {
                $token = $_GET[self::$token_session_name];
                if ($token == $_SESSION[self::$token_session_name][$token]) {
                    unset($_SESSION[self::$token_session_name][$token]);
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }

    }


    class text extends element
    {
        protected $placeholder, $max_length, $value;
        protected $field_type = 'text';
        protected $prepended, $appended;


        /*
        * Construct
        * @oa	Will
        */
        public function __construct($label, $placeholder = FALSE, $max_length = FALSE, $value = FALSE)
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
        public function prepend($text)
        {
            $this->prepended = $text;
        }

        /*
        * Append
        * @oa	Will
        */
        public function append($text)
        {
            $this->appended = $text;
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

    /*
    * Text Area
    * @author Will
    *
    */
    class textarea extends text
    {
        public $rows, $cols;

        /*
        * Construct
        * @author Will
        */
        public function __construct($label, $value = FALSE)
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

    /*
    * Password Elements
    * @oa	Will
    *
    */
    class password extends text
    {

        /*
        * Construct
        * @oa	Will
        */
        public function __construct($label, $placeholder = FALSE, $max_length = FALSE, $value = FALSE)
        {
            parent::__construct($label, $placeholder, $max_length, $value);
            $this->field_type = 'password';
        }
    }

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
    }

    /*
    * Elements that have multiple options
    * @oa	Will
    */
    abstract class option extends element
    {

        protected $options = array();

        /*
        * Construct
        * @oa	Will
        *
        * options is either an array of
        * value => label pairs
        * or an array of option arrays with
        * 	[label]
        * 	[value]
        * 	[attributes] ->array
        *
        */
        public function __construct($label, $options)
        {
            $this->label   = $label;
            $this->options = $options;
        }
    }

    /*
    * Select
    * @oa Will
    */
    class select extends option
    {
        /*
        * Render
        * @oa Will
        *
        * //WBN sanity check to see if there are any options
        *
        */
        public function render($name)
        {
            $html = $this->label();
            $html .= '<select name ="' . $name . '"' . $this->element_attributes . ' >';

            foreach ($this->options as $key => $option) {

                $option_attributes = '';

                if (is_array($option)) {

                    if (isset($option['attributes'])) {
                        foreach ($option['attributes'] as $key => $attribute) {
                            $option_attributes .= ' ' . $key . '="' . $attribute . '"';
                        }
                    }

                    if (!isset($option['value'])) {
                        throw new \Exception('All options need to have a value');
                    } else {
                        $value = $option['value'];
                    }

                    if (!isset($option['label'])) {
                        $option['label'] = $option['value'];
                    }

                    $label = $option['label'];

                } else {
                    $label = $option;
                    $value = $key;
                }

                $option_attributes .= ' value="' . $value . '"';
                $html .= "<option $option_attributes >" . $label . '</option>';
            }

            $html .= '</select>';

            return $html;
        }

    }


