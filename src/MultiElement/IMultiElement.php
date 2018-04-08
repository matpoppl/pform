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

interface IMultiElement
{
    public function getMultiOptions();
    
    public function getMultiLabel($key);
    
    public function getMultiValue($key);
    
    public function isMultiple();
    
    public function renderPrepareOption($key);
}
