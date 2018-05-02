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

class SubForm extends AbstractForm
{
    public function render()
    {
        $attrs = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
        ) + $this->getAttrs();
        
        return '<fieldset' . self::renderAttrs($attrs) . '>' . parent::render() . '</fieldset>';
    }
}
