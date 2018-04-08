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

class Label extends HtmlElement
{
    const NO_LABEL = 0;
    const OUTSIDE_BEFORE = 1;
    const OUTSIDE_AFTER = 2;
    const INSIDE_BEFORE = 3;
    const INSIDE_AFTER = 4;

    /**
     * 
     * @param string $label
     * @param array $attrs
     * @param string $content
     * @param int $position
     * @throws \DomainException
     * @return string
     */
    public static function renderLabel($label, array $attrs, $content = null, $position = self::OUTSIDE_BEFORE)
    {
        if (! $label) {
            return '';
        }
        
        $start = '<label'.self::renderAttrs($attrs).'>';
        
        switch ($position) {
            case Label::NO_LABEL:
                return $content;
            case Label::OUTSIDE_BEFORE:
                return $start . self::escape($label) . '</label>' . $content;
            case Label::OUTSIDE_AFTER:
                return $content . $start . self::escape($label) . '</label>';
            case Label::INSIDE_BEFORE:
                return $start . self::escape($label) . $content . '</label>';
            case Label::INSIDE_AFTER:
                return $start . $content . self::escape($label) . '</label>';
        }
        
        throw new \DomainException('Unsupported position');
    }
}
