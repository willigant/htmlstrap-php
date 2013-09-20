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


namespace willwashburn;

class table extends html
{
    protected
        $data,
        $table_headers;
    protected $delete_col = false, $delete_url = '';
    protected $hidden_columns = array();
    protected $primary_key = 'id';

    protected $render_attributes_list = array('class','id');

    /**
     * @author   Khaliq
     *
     * @param array $data
     */

    public function __construct($data = false)
    {
        if ($data) {
            $this->addData($data);
        }

        $this->addAttribute('class', 'table');
    }

    /**
     * @author  Will
     *
     * @param $data
     *
     * @return $this
     */
    public function addData($data)
    {
        $this->data          = $data;
        $this->table_headers = $this->keys();

        return $this;
    }

    /**
     * @author           Will
     * @description      Adds a column that will be used to delete the row using the address
     *
     * @return $this
     */
    public function addDeleteColumn($url)
    {
        $this->delete_url = $url;
        $this->delete_col = true;

        return $this;

    }

    /**
     * @author  Will
     *
     * @param array $row
     */
    public function addRow(Array $row, $row_key = false)
    {
        if ($row_key) {
            $this->data[$row_key] = $row;

            return $this;
        }

        $this->data[] = $row;

        return $this;

    }

    /**
     * @author  Will
     */
    public function bordered()
    {
        $this->addAttribute('class', 'table-bordered');

        return $this;

    }

    /**
     * @author  Will
     */
    public function condensed()
    {
        $this->addAttribute('class', 'table-condensed');

        return $this;
    }

    public function getData()
    {
        return $this->data;
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
    public function hideColumns( /* Array of columns */)
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
     *
     * @return table
     */
    public function makeHeadersPretty()
    {


        foreach ($this->table_headers as $key => $header) {

            $pretty_header = str_replace('_', ' ', $header);
            $pretty_header = ucwords($pretty_header);

            $this->table_headers[$key] = $pretty_header;

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
    public function renameColumn($column_name, $new_header)
    {
        $pos = array_search($column_name, $this->table_headers);
        if ($pos) {
            $this->table_headers[$pos] = $new_header;
        }

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
        $keys = $this->table_headers = $this->keys();

        $html = '<table ';

        foreach ($this->render_attributes_list as $attribute) {
            $this->attributize($attribute);
            $html .= $this->$attribute . ' ';
        }
        $html .= '>';
        $html .= '<thead>';

        if ($this->delete_col) {
            $html .= '<th> &nbsp; </th>';
        }

        foreach ($this->table_headers as $header) {

            $html .= '<th>' . $header . '</th>';
        }
        $html .= '</thead>';
        $html .= '<tbody>';

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
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';

        return $html;
    }

    /**
     * @author  Will
     */
    public function striped()
    {
        $this->addAttribute('class', 'table-striped');

        return $this;
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
}
