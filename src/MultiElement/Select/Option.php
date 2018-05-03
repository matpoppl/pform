<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pform\MultiElement\Select;

use pform\Core\HtmlElement;

class Option extends HtmlElement
{
    private $value;
    
    public function __construct($value, $name, array $options = null)
    {
        $this->value = $value;
        
        parent::__construct($name, $options);
    }
    
    public function render()
    {
        $attrs = array(
            //'id' => $this->getId(),
            'value' => $this->value,
        ) + $this->getAttrs();
        
        return '<option' . self::renderAttrs($attrs) . '>' . self::escape($this->getName()) . '</option>';
    }
}