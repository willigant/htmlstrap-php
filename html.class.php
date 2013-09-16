<?php

    /*
     * Abstract Html Class
     * @author Will
     *
     * when we are creating html elements, this is a good base class
     *
     */
    namespace willwashburn;

    abstract class html
    {
        public $id;
        protected $class, $style;
        protected $html = '', $attributes = '';

        /*
        * Create attribute string
        * @author Will
        *
        * @return string of the attribute
        * eg  class = "classname otherclass"
        *
        */
        protected function attributize($attribute, $data = FALSE,$overwrite_attribute_name = false)
        {
            if (!$data) {
                if (isset($this->$attribute)) {
                    $data = $this->$attribute;
                } else {
                    $data = FALSE;
                }
            }

            if (!$overwrite_attribute_name) {
                $attribute_name = $overwrite_attribute_name;
            } else {
                $attribute_name = $attribute;
            }


            if ($data) {
                $string_to_return = ' ' . $attribute_name . '="';
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


        public function addClass ($class) {
            $this->add_attribute('class',$class);
        }

        public function removeClass($class) {
            $this->remove_attribute('class',$class);
        }

        /**
         * add to an array of what will be an html attribute string
         * @author	Will Washburn
         *
         * @example
         *
         * eg add 'class',' foo' and 'class','bar' and when you call attributize it will make it
         * class ="foo bar"
         *
         *
         */
        protected function addAttribute($attribute_name, $attribute)
        {
            if (is_array($this->$attribute_name)) {
                $add = array($attribute => $attribute);
                $this->array_push_associative($this->$attribute_name, $add);
            } else {
                $this->$attribute_name = array($attribute => $attribute);
            }
        }

        /**
         * Remove attribute
         * removes specific attribute from created attribute array
         * @author  Will Washburn
         *
         */
        protected function removeAttribute($attribute_name, $attribute)
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
        protected function array_push_associative(&$arr)
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
