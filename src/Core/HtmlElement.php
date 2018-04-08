<?php
/*
 * This file is part of pform.
 *
 * (c) matpoppl
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace pform\Core;

abstract class HtmlElement
{
    /**
     * @var string
     */
    private $id;
    
    /**
     * @var string
     */
    private $name;
    
    /**
     * @var array
     */
    private $attrs = array();

    /**
     * @var HtmlElement
     */
    private $parentNode = null;
    
    /**
     * @param string $name
     * @param array $options
     */
    public function __construct($name, array $options = null)
    {
        $this->name = $name;
        
        if (null !== $options) {
            $this->setOptions($options);
        }
    }
    
    /**
     * @return mixed
     */
    public function getAttr($key, $default = null)
    {
        return isset($this->attrs[$key]) ? $this->attrs[$key] : $default;
    }
    
    /**
     * @return array
     */
    public function getAttrs()
    {
        return $this->attrs;
    }

    /**
     * @param array $opts
     * @return \pform\Core\HtmlElement
     */
    public function setOptions(array $opts)
    {
        foreach ($opts as $key => $val) {
            $methodName = 'set' . ucfirst($key);
            
            if (method_exists($this, $methodName)) {
                $this->{$methodName}($val);
                unset($opts[$key]);
            }
        }
        
        $this->attrs = array_merge($this->attrs, $opts);
        
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * @param string $name
     * @return \pform\Core\HtmlElement
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getId()
    {
        return $this->id ?: $this->getName();
    }
    
    /**
     * @param string $id
     * @return \pform\Core\HtmlElement
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return \pform\Core\HtmlElement
     */
    public function getParentNode()
    {
        return $this->parentNode;
    }

    /**
     * @param \pform\Core\HtmlElement $parentNode
     * @return \pform\Core\HtmlElement
     */
    public function setParentNode(HtmlElement $parentNode)
    {
        $this->parentNode = $parentNode;
        return $this;
    }

    /**
     * @param string $str
     * @return string
     */
    public static function escape($str)
    {
        return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param array $attrs
     * @return string
     */
    public static function renderAttrs(array $attrs)
    {
        $ret = '';
        
        foreach ($attrs as $key => $val) {
            if (null === $val) {
                continue;
            }
            
            switch (gettype($val)) {
                case 'bool':
                case 'boolean':
                    if ($val) {
                        $ret .= ' ' . self::escape($key) . '=""';
                    }
                    break;
                case 'object':
                    $ret .= ' ' . self::escape($key) . '="' . self::escape(json_encode($val)) . '"';
                    break;
                case 'array':
                    if (! empty($val)) {
                        $ret .= ' ' . self::escape($key) . '="' . self::escape(implode(' ', $val)) . '"';
                    }
                    break;
                default:
                    if ('' !== $val) {
                        $ret .= ' ' . self::escape($key) . '="' . self::escape($val) . '"';
                    }
            }
        }
        
        return $ret;
    }
}
