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
use Exception;

class panel extends table
{

    /**
     * Render
     *
     * @author          Khaliq
     * @author          Will
     *
     * take the data and create a table
     *  ->checks hidden colums and doesnt show the ones in the list
     *
     */
    public function addForm()
    {
    }


    /**
    * Panel Delete row
    * @author Will
    * @description   this doesn't make sense in a panel so it throws an error
    *
    *
    */

    public function deleteColumn()
    {
        throw new Exception('Panels can not have a delete column yet.');
    }

    /**
     * Form
     * @author      Khaliq
     * @contributor Will
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
}


