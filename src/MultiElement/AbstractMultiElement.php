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

use pform\Element\AbstractLabeledElement;

abstract class AbstractMultiElement extends AbstractLabeledElement implements MultiElementInterface, \Iterator, \Countable
{

    protected $separator;

    private $multiple = false;

    private $multiOptions = array();

    private $iterKeys = array();

    private $iterPointer = 0;

    private $iterCount = 0;

    public function __construct($name, array $multiOptions, array $options = null)
    {
        $this->multiOptions = array_map(function($row) {
            return is_array($row) ? $row : array('label' => $row);
        }, $multiOptions);
        
        parent::__construct($name, $options);
        
        if ($this->isMultiple()) {
            $this->value = array();
        }
    }

    public function isMultiple()
    {
        return $this->multiple;
    }

    /**
     *
     * @return mixed
     */
    public function getSeparator()
    {
        return $this->separator;
    }

    /**
     *
     * @param mixed $separator
     */
    public function setSeparator($separator)
    {
        $this->separator = $separator;
        return $this;
    }
    
    public function setMultiple($multiple)
    {
        $this->multiple = $multiple;
        return $this;
    }
    
    public function getMultiOptions()
    {
        return $this->multiOptions;
    }
    
    public function getMultiKeys()
    {
        return array_keys($this->multiOptions);
    }
    
    public function getMultiLabel($key)
    {
        return isset($this->multiOptions[$key]) ? $this->multiOptions[$key]['label'] : null;
    }
    
    public function getMultiValue($key, $is = false)
    {
        if (! is_array($this->value)) {
            throw new \UnexpectedValueException('Array type of Value required');
        }
        
        if ($is) {
            return isset($this->value[$key]) ? $this->value[$key] : null;
        }
        
        return in_array($key, $this->value) ? $key : null;
    }
    
    public function renderView()
    {
        $ret = '';
        
        foreach (array_keys($this->multiOptions) as $key) {
            $ret .= $this->renderPrepareOption($key)->render() . $this->getSeparator();
        }
        
        return $ret;
    }

    public function setValue($value)
    {
        if ($this->isMultiple()) {
            return parent::setValue(is_array($value) ? $value : array(
                $value
            ));
        }
        
        return parent::setValue(is_array($value) ? current($value) : $value);
    }

    public function rewind()
    {
        $multiOptions = $this->getMultiOptions();
        $this->iterKeys = array_keys($multiOptions);
        $this->iterPointer = 0;
        $this->iterCount = count($multiOptions);
    }

    public function valid()
    {
        return $this->iterPointer < $this->iterCount;
    }

    public function key()
    {
        return $this->iterKeys[$this->iterPointer];
    }

    public function current()
    {
        return $this->renderPrepareOption($this->key());
    }

    public function next()
    {
        $this->iterPointer++;
    }
    
    public function count()
    {
        return count($this->multiOptions);
    }
}
