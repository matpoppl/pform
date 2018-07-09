<?php

namespace pform\Form;

use PHPUnit\Framework\TestCase;
use pform\Element\Input;

class FormTest extends TestCase
{
    public function testAttribs()
    {
        $form = new Form('foo', [
            'id' => 'bar',
            'method' => 'post',
            'enctype' => Form::ENCTYPE_MULTIPART,
        ]);
        
        self::assertXmlStringEqualsXmlString('<form name="foo" id="bar" enctype="' . Form::ENCTYPE_MULTIPART . '" method="post"></form>', $form->render());
    }
    
    public function testElement()
    {
        $form = new Form('foo');
        
        $expected = new Input('text', 'bar');
        
        $form->setElement($expected);
        
        self::assertEquals($expected, $form->getElement('bar'));
    }
    
    public function testRender()
    {
        $form = new Form('foo');
        
        $form->setElement(new Input('text', 'bar'));
        
        $expected = '<form id="foo" name="foo"><div><input type="text" id="foo-bar" name="foo[bar]" /></div></form>';
        
        self::assertXmlStringEqualsXmlString($expected, $form->render());
    }
    
    public function testValues()
    {
        $form = new Form('foo');
        
        $form->setElement(new Input('text', 'bar'));
        
        $form->setElement(new Input('text', 'baz', [
            'disabled' => true,
        ]));
        
        $expected = [
            'bar' => 'baz',
        ];
        
        $form->setValue($expected + [
            'mustIgnore' => 'yes',
            'baz' => 'boom',
        ]);
        
        self::assertEquals($expected, $form->getValue());
    }
}