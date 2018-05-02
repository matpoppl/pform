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

class Form extends AbstractForm
{

    const ENCTYPE_URLENCODED = 'application/x-www-form-urlencoded';

    const ENCTYPE_MULTIPART = 'multipart/form-data';

    const ENCTYPE_PLAIN = 'text/plain';

    private $enctype = self::ENCTYPE_URLENCODED;

    /**
     *
     * @return string
     */
    public function getEnctype()
    {
        return $this->enctype;
    }

    /**
     *
     * @param string $enctype
     */
    public function setEnctype($enctype)
    {
        $this->enctype = $enctype;
        return $this;
    }
    
    public function render()
    {
        $attrs = array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'enctype' => $this->getEnctype()
        ) + $this->getAttrs();
        
        
        return '<form' . self::renderAttrs($attrs) . '>' . parent::render() . '</form>';
    }
}
