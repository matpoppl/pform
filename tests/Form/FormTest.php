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

use PHPUnit\Framework\TestCase;

use pform\Element\Button;
use pform\Element\Input;

class FormTest extends TestCase
{
    public function testRenderAttribs()
    {
        $form = new Form([
            'id' => 'bar',
            'name' => 'foo',
            'method' => 'TEST',
            'action' => '/baz',
            'enctype' => Form::ENCTYPE_MULTIPART,
        ]);
        
        self::assertXmlStringEqualsXmlString('<form action="/baz" name="foo" id="bar" enctype="' . Form::ENCTYPE_MULTIPART . '" method="TEST"></form>', $form->render());
    }
    
    public function testRenderChildren()
    {
        $form = new Form([
            'id' => 'foo1',
            'name' => 'foo2',
        ]);
        
        $form->setElement(new Input('text', 'bar'));
        
        $expected = '<form id="foo1" name="foo2"><div><input type="text" id="bar" name="bar" /></div></form>';
        
        self::assertXmlStringEqualsXmlString($expected, $form->render());
    }
    
    public function testRenderChildrenSubname()
    {
        $form = new Form();
        
        $form->setElement(new Button('submit', 'foo', array(
            'label' => 'bar',
        )));
        
        $expected = '<form><div><button type="submit" id="foo" name="foo">bar</button></div></form>';
        
        self::assertXmlStringEqualsXmlString($expected, $form->render());
    }
    
    public function testGetElement()
    {
        $form = new Form();
        
        $expected = new Input('text', 'bar');
        
        $form->setElement($expected);
        
        self::assertEquals($expected, $form->getElement('bar'));
    }
    
    public function testValues()
    {
        $values = array(
            'foo' => '111',
            'bar' => '222',
        );
        
        $form = new Form();
        
        $form->setElement(new Input('text', 'foo'));
        
        $form->setElement(new Input('text', 'bar'));
        
        $form->setElement(new Input('text', 'baz', [
            'disabled' => true,
        ]));
        
        $form->setValue($values + [
            'mustIgnore' => 'yes',
            'baz' => 'boom',
        ]);
        
        $expected = '<form>'
            .'<div><input type="text" name="foo" value="111" id="foo" /></div>'
            .'<div><input type="text" name="bar" value="222" id="bar" /></div>'
            .'<div><input type="text" name="baz" id="baz" disabled="" /></div>'
            .'</form>';
        
        self::assertXmlStringEqualsXmlString($expected, $form->render());
        
        self::assertEquals($values, $form->getValue());
    }
}
