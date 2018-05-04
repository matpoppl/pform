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
    public function testConstructor()
    {
        $form = new Form(array(
            'id' => 'foo',
            'name' => 'bar',
            'enctype' => Form::ENCTYPE_PLAIN,
            'action' => '/baz',
            'method' => 'TEST',
        ));
        
        $expected = '<form id="foo" name="bar" enctype="text/plain" action="/baz" method="TEST"></form>';
        
        self::assertEquals($expected, $form->render());
    }
    
    public function testElements()
    {
        $form = new Form();
        
        $form->setElement(new Button('submit', 'foo', array(
            'label' => 'bar',
        )));
        
        $expected = '<form enctype="application/x-www-form-urlencoded"><div><button type="submit" id="foo" name="foo">bar</button></div></form>';
        
        self::assertEquals($expected, $form->render());
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
        
        $form->setValue($values);
        
        $expected = '<form enctype="application/x-www-form-urlencoded">'
            .'<div><input type="text" name="foo" value="111" id="foo" /></div>'
            .'<div><input type="text" name="bar" value="222" id="bar" /></div>'
            .'</form>';
        
        self::assertEquals($expected, $form->render());
        self::assertEquals($values, $form->getValue());
    }
}
