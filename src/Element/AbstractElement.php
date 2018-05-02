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

use pform\Core\HtmlElement;

abstract class AbstractElement extends HtmlElement implements ElementInterface
{
    protected $value;

    private $errors = array();

    abstract public function renderView();

    /**
     *
     * @param string $error
     * @return \pform\Element\AbstractElement
     */
    public function addError($error)
    {
        $this->errors[] = $error;
        return $this;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function setValue($value)
    {
        if ($this->isWritable()) {
            $this->value = $value;
        }
        
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }
    
    public function isWritable()
    {
        return ! $this->getAttr('disabled') && ! $this->getAttr('readonly');
    }
    
    public function renderErrors()
    {
        return $this->errors ? '<ul class="form-erros"><li>' . implode('</li><li>', $this->errors) . '</li></ul>' : '';
    }

    public function render()
    {
        return $this->renderView() . $this->renderErrors();
    }
}
