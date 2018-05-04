<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace pform\Element;

class Button extends AbstractElement
{
    private $label;
    private $type;

    public function __construct($type, $name, array $options = null)
    {
        $this->type = $type;
        
        parent::__construct($name, $options);
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
    
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function renderView()
    {
        $attrs = array(
            'type' => $this->getType(),
            'id' => $this->getId(),
            'name' => $this->getName(),
            
            'value' => $this->getValue(),
        ) + $this->getAttrs();
        
        return '<button'.self::renderAttrs($attrs).'>'.self::escape($this->getLabel()).'</button>';
    }
}
