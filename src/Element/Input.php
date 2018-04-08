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

class Input extends ALabeledElement
{
    /**
     * Input type
     * @var string
     */
    private $type;

    /**
     * @param string $type
     * @param string $name
     * @param array $opts
     */
    public function __construct($type, $name, array $opts = null)
    {
        $this->type = $type;
        
        parent::__construct($name, $opts);
    }

    public function renderView()
    {
        return self::renderInput($this->type, $this->getName(), $this->getValue(), $this->getId(), $this->getAttrs());
    }
    
    public static function renderInput($type, $name, $value, $id = null, array $attributes = null)
    {
        $attrs = array(
            'type' => $type,
            'name' => $name,
            'value' => $value,
            'id' => $id ?: $name,
        );
        
        if (null !== $attributes) {
            $attrs += $attributes;
        }
        
        return '<input'.self::renderAttrs($attrs).' />';
    }
}
