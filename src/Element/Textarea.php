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

class Textarea extends AbstractLabeledElement
{

    public function renderView()
    {
        $attrs = array(
            'name' => $this->getName(),
            'id' => $this->getId()
        ) + $this->getAttrs();
        
        return '<textarea' . self::renderAttrs($attrs) . '>' . self::escape($this->getValue()) . '</textarea>';
    }
}
