<?php

    /*
     * Create OL or UL (Lists)
     * @author Will
     *
     * I couldn't use list since it's already used by php so I went with lis.. as in multiple list items (li s)
     *
     */

    namespace willwashburn;

    require_once 'html.class.php';

    class lis extends html
    {

        private $data_array, $list_type;

        /*
         * Construct
         * @author Will
         *
         */
        public function __construct($data_array, $list_type = 'ul')
        {
            $this->data_array = $data_array;
            $this->list_type  = $list_type;
        }

        /*
        * Render the html
        * @author Will
        */
        public function render()
        {
            return $this->render_list_items($this->data_array);
        }

        /*
         * Render LI html
         * @author  Will
         *
         */
        private function render_list_items($data, $parents = 0)
        {

            $html = '';
            $parents++;

            if (!is_array($data)) {
                return $data;
            }

            if (empty($data)) {
                return '';
            }

            $html .= "<$this->list_type $this->attributes> ";

            $this->attributes = '';

            foreach ($data as $key => $sub_array) {
                $html .= "<li>";
                $html .= $this->render_list_items($sub_array,$parents);
                $html .= "</li>";
            }
            $html .= "</$this->list_type>";

            return $html;

        }
    }
