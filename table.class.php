<?php
    /**
     * @author           Khaliq
     * @author           Will
     *
     * @description      Class to create tables from an array
     *                   Supports method chaining
     *
     * @example
     *          $messages_table = new table($data)
     *               ->hide_columns('user_id','updated_at')
     *               ->rename_column('phone_number','Phone Number')
     *               ->add_delete_column('/message/remove/')
     *               ->condensed()
     *               ->striped();
     *
     *
     * @todo
     *       //KTD add a license
     *       //KTD add common uses
     *      //WBN Reorder the stack to how we see fit
     *
     */


    namespace willwashbrun;

    require_once 'html.class.php';

    class table extends html
    {
        protected $data, $table_headers;
        protected $hidden_columns = array();
        protected $primary_key = 'id';
        protected $delete_col = FALSE, $delete_url = '';

        /**
         * @author   Khaliq
         *
         * @param array $data
         */

        public function __construct($data)
        {
            $this->data = $data;

            $this->table_headers = $this->keys();

            $this->add_attribute('class', 'table');
        }


        /**
         * @author  Will
         */
        public function striped()
        {
            $this->add_attribute('class', 'table-striped');
            return $this;
        }

        /**
         * @author  Will
         */
        public function bordered()
        {
            $this->add_attribute('class', 'table-bordered');
            return $this;

        }

        /**
         * @author  Will
         */
        public function condensed()
        {
            $this->add_attribute('class', 'table-condensed');
            return $this;
        }

        /**
         * @author          Khaliq
         * @author          Will
         *
         * take the data and create a table
         *  ->checks hidden colums and doesnt show the ones in the list
         *
         *
         * @todo
         *      //WWBN be able to have delete urls with ? query strings
         *      //WBN put warning before delete action
         *      //WBN make aforementioned warning optional
         *
         */
        public function render()
        {
            $keys = $this->keys();

            $this->attributize('class');
            $html = '<table ' . $this->class . '>';
            $html .= '<thead>';

            if ($this->delete_col) {
                $html .= '<th> &nbsp; </th>';
            }

            foreach ($this->table_headers as $header) {

                $html .= '<th>' . $header . '</th>';
            }
            $html .= '</thead>';

            foreach ($this->data as $rows) {
                $html .= '<tr>';

                if ($this->delete_col) {
                    $html .= '<td> <a class="icon-trash" href="' . $this->delete_url . '?' . $this->primary_key . '=' . $rows[$this->primary_key] . '"></a></td>';
                }

                foreach ($rows as $key => $value) {
                    if (in_array($key, $keys)) {
                        $html .= '<td>' . $value . '</td>';
                    }
                }
            }
            $html .= '</tr>';
            $html .= '</table>';

            return $html;
        }

        /**
         * @author          Will
         * @description     finds the keys that should be used in TH
         *
         * used in render function
         * checks to see if the keys are in the array of hidden columns
         *
         * @returns array of the keys
         */
        private function keys()
        {

            $keys = array();

            if (isset($this->data[0])) {
                foreach ($this->data[0] as $key => $value) {
                    if (!in_array($key, $this->hidden_columns)) {
                        $keys[] = $key;
                    }
                }
            }
            return $keys;
        }

        /**
         * @author          Will
         * @description     will not display the cols listed
         *
         * adds the keys to an array that is used in render function
         *
         * @example
         * $panel->hide_columns('fb_key', 'fb_app_id', 'fb_secret');
         *
         *
         * @todo
         *       //WBN add ability to pass an array as well as an argument
         */
        public function hide_columns( /* Array of columns */)
        {
            if (!empty($this->table_headers)) {
                $columns_to_hide = func_get_args();

                foreach ($columns_to_hide as $col) {
                    $this->hidden_columns[$col] = $col;

                    $pos = array_search($col, $this->table_headers);
                    if (array_key_exists($pos, $this->table_headers)) {
                        unset($this->table_headers[$pos]);
                    }

                }
            }

            return $this;
        }

        /**
         * @author  Will
         * @todo
         *          use keys to keep things straight so we dont unhide doing this
         *
         * @param $column_name
         * @param $new_header
         *
         * @return \htmlstrap\table
         */
        public function rename_column($column_name, $new_header)
        {
            $pos = array_search($column_name, $this->table_headers);
            if ($pos) {
                $this->table_headers[$pos] = $new_header;
            }

            return $this;
        }

        /**
         * @author           Will
         * @description      Adds a column that will be used to delete the row using the address
         *
         */
        public function add_delete_column($url)
        {
            $this->delete_url = $url;
            $this->delete_col = TRUE;

            return $this;

        }


        /**
         * @author  Will
         *
         * @return table
         */
        public function make_headers_pretty()
        {


            foreach ($this->table_headers as $key=> $header) {

                $pretty_header = str_replace('_', ' ', $header);
                $pretty_header = ucwords($pretty_header);

                $this->table_headers[$key] = $pretty_header;

            }

            return $this;
        }


    }







