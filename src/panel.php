<?php namespace WilliGant;

use Exception;

class panel extends table
{
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


