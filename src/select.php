<?php namespace WilliGant;


class select extends option
{
    /**
     * Render
     *
     * @author Will
     *
     * //WBN sanity check to see if there are any options
     *
     */
    public function render($name)
    {
        $html = $this->label();
        $html .= '<select name ="' . $name . '"' . $this->element_attributes . ' >';

        foreach ($this->options as $key => $option) {

            $option_attributes = '';

            if (is_array($option)) {

                if (isset($option['attributes'])) {
                    foreach ($option['attributes'] as $key => $attribute) {
                        $option_attributes .= ' ' . $key . '="' . $attribute . '"';
                    }
                }

                if (!isset($option['value'])) {
                    throw new \Exception('All options need to have a value');
                } else {
                    $value = $option['value'];
                }

                if (!isset($option['label'])) {
                    $option['label'] = $option['value'];
                }

                $label = $option['label'];

            } else {
                $label = $option;
                $value = $key;
            }

            $option_attributes .= ' value="' . $value . '"';
            $html .= "<option $option_attributes >" . $label . '</option>';
        }

        $html .= '</select>';

        return $html;
    }

}