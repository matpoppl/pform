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

abstract class AbstractLabeledElement extends AbstractElement
{
    /**
     * 
     * @var string
     */
    private $label;

    /**
     * 
     * @var array
     */
    private $labelAttrs = array();

    protected $labelPosition = Label::OUTSIDE_BEFORE;

    /**
     *
     * @return string
     */
    public function hasLabel()
    {
        return !! $this->label;
    }

    /**
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label ?: $this->getName();
    }

    /**
     *
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getLabelAttrs()
    {
        return $this->labelAttrs;
    }

    public function setLabelAttrs($labelAttrs)
    {
        $this->labelAttrs = $labelAttrs;
        return $this;
    }

    public function setLabelPosition($labelPosition)
    {
        $this->labelPosition = $labelPosition;
        return $this;
    }

    /**
     * @param string $content
     * @param int $position
     * @return string
     */
    public function renderLabel($content = null, $position = Label::OUTSIDE_BEFORE)
    {
        if (! $this->hasLabel()) {
            return $content;
        }
        
        $attrs = array(
            'for' => $this->getId()
        ) + $this->getLabelAttrs();
        
        return Label::renderLabel($this->getLabel(), $attrs, $content, $position);
    }

    public function render()
    {
        return $this->renderLabel($this->renderView(), $this->labelPosition) . $this->renderErrors();
    }
}
