<?php

namespace willwashburn;

/**
 * Buttons
 *
 * @author    Will
 *
 */
class button extends element
{

    public $clear = true;
    protected $tag_type = 'button';
    protected $text, $theme, $size, $icon;
    protected $type = 'button';

    /*
    * Construct
    * @oa Will
    */

    public function __construct($text = 'Submit', $theme = 'default', $size = 'default', $icon = false)
    {
        $this->text  = $text;
        $this->theme = $theme;
        $this->size  = $size;
        $this->icon  = $icon;

    }

    /*
    * Render
    * @oa	Will
    */

    public function render($name)
    {
        $this->addAttribute('class', 'btn');

        if ($this->theme != 'default') {
            $this->addAttribute('class', 'btn-' . $this->theme);
        }

        if ($this->size != 'default') {
            $this->addAttribute('class', 'btn-' . $this->size);
        }

        parent::render($name);

        if ($this->clear) {
            $this->html .= '<div>&nbsp;</div>';
        }

        switch ($this->tag_type) {
            default:
            case 'a':
                //WBN this is broken sort of, fix that ish
                $this->html .= '<a href="/" ' . $this->element_attributes . '>' . $this->text . '</a>';
                break;
            case 'input':
                $this->html .= '<input ' . $this->element_attributes . 'type ="' . $this->type . '" value="' . $this->text . '" />';
                break;
            case 'button':
                $this->html .= '<button ' . $this->element_attributes . ' type ="' . $this->type . '" >' . $this->text . '' . $this->icon . '</button>';
                break;
            case 'icon_submit':
                $this->html .= '<button ' . $this->element_attributes . ' type ="' . $this->type . '" >' . $this->text . '' . $this->icon . '</button>';
                break;
        }

        return $this->html;
    }
}


