<?php
    /*
    * Created by Khaliq Gant
    * Date: 6/12/12
    * Time: 3:09 PM
    * @use to make a panel table quickly
    * @description
    *
    *
    * //KTD put comments on the functions that describe what they do, what they are expected to return etc
    *
    */

    namespace willwashburn;

    include_once 'table.class.php';

    class panel extends table
    {

        /*
        * Render
        * @author          Khaliq
        * @contributor     Will
        *
        * take the data and create a table
        *  ->checks hidden colums and doesnt show the ones in the list
        *
        */
        public function render()
        {
            $this->attributize('class');

            $html = '<table ' . $this->class . '>';
            foreach ($this->data as $key => $value) {
                if (!in_array($key, $this->hidden_columns)) {
                    $html .= '<tr><th>' . $key . '</th>';
                    $html .= '<td>' . $value . '</td></tr>';
                }
            }
            $html .= '</table>';

            return $html;
        }


        /*
        * Panel Delete row
        * @author Will
        * @description   this doesn't make sense in a panel so it throws an error
        *
        *
        */
        public function delete_column()
        {
            throw new \Exception('Panels can not have a delete column yet.');
        }

        /*
         * Form
         * @author      Khaliq
         * @contributor Will
         *
         * //KTD add a form to the panel that is able to be saved to a model
         *
         *
         */
        public function add_form()
        {
        }
    }


