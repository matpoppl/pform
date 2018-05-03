<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pform\MultiElement;

use pform\Element\Label;
use pform\Element\Input;

class MultiInput extends AbstractMultiElement
{
    private $type;

    protected $separator = '<br />';

    public function __construct($type, $name, array $multiOptions, array $opts = null)
    {
        $this->type = $type;
        
        switch ($this->type) {
            case 'radio':
            case 'checkbox':
                $this->setLabelPosition(Label::INSIDE_AFTER);
                break;
        }
        
        $this->setMultiple('radio' !== $type);

        parent::__construct($name, $multiOptions, $opts);
    }
    
    public function getMultiValue($key)
    {
        if (! is_array($this->value)) {
            throw new \UnexpectedValueException('Array type of Value required');
        }
        
        return isset($this->value[$key]) ? $this->value[$key] : null;
    }
    
    public function renderPrepareOption($key)
    {
        $opts = array(
            'label' => $this->getMultiLabel($key),
            'id' => $this->getId() . '-' . $key,
            'labelPosition' => $this->labelPosition,
            'labelAttrs' => $this->getLabelAttrs(),
        ) + $this->getAttrs();
        
        switch ($this->type) {
            case 'radio':
                $opts['value'] = $key;
                $opts['checked'] = $key === $this->getValue();
                break;
            case 'checkbox':
                $opts['value'] = $key;
                $opts['checked'] = null !== $this->getMultiValue($key);
                break;
            default:
                $opts['value'] = $this->getMultiValue($key);
                $opts['checked'] = false;
        }
        
        $input = new Input($this->type, $this->getName() . ($this->isMultiple() ? '[' . $key . ']' : ''), $opts);
        
        return $input;
    }
}
