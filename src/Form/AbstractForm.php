<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace pform\Form;

use pform\Core\HtmlElement;
use pform\Element\ElementInterface;

abstract class AbstractForm extends HtmlElement implements ElementInterface
{
    
    /**
     *
     * @var ElementInterface[]
     */
    private $elements = array();
    
    private function resetIdName($name, ElementInterface $element)
    {
        $id = $element->getId();
        
        $element->setId($this->getId() . '-' . $id);
        $element->setName($this->getName() . '[' . $name . ']');
       
        return $this;
    }
    
    /**
     * @param \pform\Core\HtmlElement $parentNode
     * @return \pform\Core\HtmlElement
     */
    public function setParentNode(HtmlElement $parentNode)
    {
        foreach ($this->elements as $name => $element) {
            $this->resetIdName($name, $element);
        }
        
        return parent::setParentNode($parentNode);
    }
    
    /**
     * @param ElementInterface $element
     * @return \pform\Form\Form
     */
    public function setElement(ElementInterface $element)
    {
        $name = $element->getName();
        
        $this->resetIdName($name, $element);
        
        if ($element instanceof HtmlElement) {
            $element->setParentNode($this);
        }
        
        $this->elements[$name] = $element;
        
        return $this;
    }

    public function setElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->setElement($element);
        }
        
        return $this;
    }

    public function hasElement($name)
    {
        return isset($this->elements[$name]);
    }

    public function getElement($name)
    {
        return isset($this->elements[$name]) ? $this->elements[$name] : null;
    }

    /**
     *
     * @param array $values
     * @param boolean $skipNotSet
     *            Set only values that exists. Don't overwrite with NULL.
     * @return \pform\Form\Form
     */
    private function setValues(array $values, $skipNotSet = false)
    {
        foreach ($this->elements as $name => $elem) {
            $value = isset($values[$name]) ? $values[$name] : null;
            
            if (! $skipNotSet || null !== $value) {
                $elem->setValue($value);
            }
        }
        
        return $this;
    }

    public function setValue($values)
    {
        // array required
        if (null === $values) {
            $values = array();
        }
        
        if (! is_array($values)) {
            throw new \UnexpectedValueException('Value of Array type required');
        }
        
        $name = $this->getName();
        
        return $this->setValues(isset($values[$name]) ? $values[$name] : $values);
    }
    
    public function render()
    {
        $ret = '';
        
        foreach ($this->elements as $elem) {
            // is form
            if ($elem instanceof self) {
                // forms dont need wrapper
                $ret .= $elem->render();
                continue;
            }
            
            // add wrapper
            $ret .= '<div>' . $elem->render() . '</div>';
        }
        
        return $ret;
    }

    public function getValue()
    {
        $ret = array();
        
        foreach ($this->elements as $name => $elem) {
            if ($elem->isWritable()) {
                $ret[$name] = $elem->getValue();
            }
        }
        
        return $ret;
    }
    
    public function setErrors(array $errors)
    {
        foreach (array_intersect_key($this->elements, $errors) as $key => $elem) {
            $msgs = is_array($errors[$key]) ? $errors[$key] : array($errors[$key]);
            
            $elem->setErrors($msgs);
            unset($errors[$key]);
        }
        
        $this->errors = $errors;
        
        return $this;
    }
    
    public function addError($msg)
    {
        throw new \Exception('Not implemented yet');
    }
    
    public function isWritable()
    {
        return ! $this->getAttr('disabled');
    }

    public function getErrors()
    {
        throw new \Exception('Not implemented yet');
    }
}
