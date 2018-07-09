<?php

namespace pform\Core;

use PHPUnit\Framework\TestCase;

class HtmlElementTest extends TestCase
{
    public function testEscape()
    {
        self::assertEquals('&lt;script src=&quot;foo&amp;foo&quot;&gt;', HtmlElement::escape('<script src="foo&foo">'));
    }
    
    public function testRenderAttrs()
    {
        $attrs = array(
            'bool' => true,
            'boolIgnored' => false,
            'nullIgnored' => null,
            'stringEmpty' => '',
            'string' => 'foo bar',
            'zero' => 0,
            'object' => (object) array(
                'foo' => 1,
                'bar' => 2,
            ),
            // keys are ignored
            'array' => array(
                3 => 'foo',
                4 => 'bar',
            ),
        );
        
        self::assertEquals(' bool="" stringEmpty="" string="foo bar" zero="0" object="{&quot;foo&quot;:1,&quot;bar&quot;:2}" array="foo bar"', HtmlElement::renderAttrs($attrs));
    }
}