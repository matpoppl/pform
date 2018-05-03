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

use pform\MultiElement\Select\Option;

class Select extends AbstractMultiElement
{
    protected $separator = '';
    
    public function getMultiValue($key)
    {
        if (! is_array($this->value)) {
            throw new \UnexpectedValueException('Array type of Value required');
        }
        
        return in_array($key, $this->value) ? $key : null;
    }
    
    public function renderView()
    {
        $attrs = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'multiple' => $this->isMultiple(),
            'disabled' => ! $this->isWritable(),
        ) + $this->getAttrs();
        
        return '<select' . self::renderAttrs($attrs) . '>' . parent::renderView() . '</select>';
    }
    
    public function renderPrepareOption($key)
    {
        // @TODO select options
        $opts = array();
        
        if ($this->isMultiple()) {
            $opts['selected'] = null !== $this->getMultiValue($key);
        } else {
            $opts['selected'] = $key === $this->getValue();
        }
        
        return new Option($key, $this->getMultiLabel($key), $opts);
    }
}
