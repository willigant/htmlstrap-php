<?php
namespace willwashburn;

/**
 * Elements that have multiple options
 *
 * @author  Will
 */

abstract class option extends element
{

    protected $options = array();

    /**
     * Construct
     *
     * @author  Will
     *
     * options is either an array of
     * value => label pairs
     * or an array of option arrays with
     *    [label]
     *    [value]
     *    [attributes] ->array
     *
     */

    public function __construct($label, $options)
    {
        $this->label   = $label;
        $this->options = $options;
    }
}