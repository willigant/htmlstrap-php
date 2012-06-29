<?php

    /*
     * Abstract Html Class
     * @author Will
     *
     * when we are creating html elements, this is a good base class
     *
     */
   namespace htmlstrap;

    class html
    {
        protected $class, $style;

        /*
        * Create attribute string
        * @author Will
        *
        * @return string of the attribute
        * eg  class = "classname otherclass"
        *
        * //WWBN add ability to overwrite attribute name in string
        * eg change "form_class" to just "class"
        *
        */
        protected function attributize($attribute, $data = FALSE)
        {
            if (!$data) {
                if (isset($this->$attribute)) {
                    $data = $this->$attribute;
                } else {
                    $data = FALSE;
                }
            }

            if ($data) {
                $string_to_return = ' ' . $attribute . '="';
                if (is_string($data)) {
                    $string_to_return .= $data;
                } elseif (is_array($data)) {
                    foreach ($data as $key => $value) {
                        $string_to_return .= ' ' . $value;
                    }
                } else {
                    $this->$attribute = '';
                }
                $string_to_return .= '"';
                $this->$attribute = $string_to_return;
            } else {
                $this->$attribute = '';
            }
        }

        /*
        * Add attribute
        * @oa	Will
        */
        protected function add_attribute($attribute_name, $attribute)
        {
            if (is_array($this->$attribute_name)) {
                $add = array($attribute => $attribute);
                $this->array_push_associative($this->$attribute_name, $add);
            } else {
                $this->$attribute_name = array($attribute => $attribute);
            }
        }

        /*
        * Remove attribute
        *
        */
        protected function remove_attribute($attribute_name, $attribute)
        {
            if (isset($this->$attribute_name[$attribute])) {
                unset($this->$attribute_name[$attribute]);
            }
        }


        /*
        * Array push
        * @author Will
        *
        * push onto array with associations
        */
        private function array_push_associative(&$arr)
        {
            $args = func_get_args();
            foreach ($args as $arg) {
                if (is_array($arg)) {
                    foreach ($arg as $key => $value) {
                        $arr[$key] = $value;
                    }
                } else {
                    $arr[$arg] = "";
                }
            }
        }
    }
