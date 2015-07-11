<?php  namespace WilliGant;

class lis extends html
{

    protected $data_array, $list_type;

    /**
     * Construct
     *
     * @author Will
     *
     */

    public function __construct($data_array, $list_type = 'ul')
    {
        $this->data_array = $data_array;
        $this->list_type  = $list_type;
    }

    /**
     * Render the html
     *
     * @author Will
     */

    public function render()
    {
        return $this->renderListItems($this->data_array);
    }

    /**
     * Render LI html
     *
     * @author  Will
     *
     */
    private function renderListItems($data, $parents = 0)
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
            $html .= $this->renderListItems($sub_array, $parents);
            $html .= "</li>";
        }
        $html .= "</$this->list_type>";

        return $html;

    }
}
