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


namespace willwashburn;

//WWBN allow different enctypes
//WBN create quick forms like "search box" or "email_pw_login" w/ different options
//WBN add control groups for horizontal forms

class form extends html
{

    private static $token_session_name = 'formstrap_token', $first_form_on_page = true;
    protected $action = false, $method = false, $class = false;
    private $fields;

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

    public function __construct($action = '', $method = 'post', $form_style = 'vertical', $well = false)
    {
        $this->fields = new \stdClass();

        if ($well) {
            $this->addAttribute('class', 'well');
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

    static public function isTokenValid($method = 'POST')
    {
        if ($method === 'POST') {

            $token = $_POST[self::$token_session_name];
            if (array_key_exists($token, $_SESSION[self::$token_session_name])) {
                if ($_POST[self::$token_session_name] == $_SESSION[self::$token_session_name][$token]) {
                    unset($_SESSION[self::$token_session_name][$token]);

                    return true;
                } else {
                    //double post
                    return true;
                }
            } else {
                return false;
            }
        } else {
            $token = $_GET[self::$token_session_name];
            if ($token == $_SESSION[self::$token_session_name][$token]) {
                unset($_SESSION[self::$token_session_name][$token]);

                return true;
            } else {
                return false;
            }
        }
    }

    public function  __get($name)
    {
        if (isset($this->fields->$name)) {
            return $this->fields->$name;
        } else {
            return false;
        }
    }

    /*
    * Change form style
    * @author Will
    */

    public function __set($name, $value)
    {
        $this->fields->$name = $value;
    }

    /*
    * Well
    * @author will
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
    * Render
    * @oa Will
    *
    * returns the HTML of the form
    *
    */

    public function style($style)
    {
        $form_styles = array(
            'vertical', 'inline', 'search', 'horizontal'
        );
        foreach ($form_styles as $style) {
            $this->removeAttribute('class', 'form-' . $style);
        }
        if (in_array($style, $form_styles)) {
            $this->addAttribute('class', 'form-' . $style);
        } else {
            throw new \Exception('That form style does not exist');
        }
    }

    /**
     * Create token session
     *
     * @oa Will
     *
     * //WTD check if the session is started
     *
     */
    public function well($set = true)
    {
        if ($set) {
            $this->addAttribute('class', 'well');
        } else {
            $this->removeAttribute('class', 'well');
        }
    }

    /**
     * Validate token session
     *
     * @oa    Will
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
            self::$first_form_on_page            = false;
            $_SESSION[self::$token_session_name] = array();
        }

        if (is_string($_SESSION[self::$token_session_name])) {
            unset($_SESSION[self::$token_session_name]);
        }
        $_SESSION[self::$token_session_name][$code] = $code;

        return $code;
    }
}
